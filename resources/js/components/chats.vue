<template>
<div>
  <div class="contacts d-lg-block"  v-if="conversations.length > 0">
    <div>
      <div
        class="
          contacts-header
          d-flex
          justify-content-between
          align-items-center
        "
      >
        <div class="my-title">
          {{ trans.methods.__("Messages") }}
        </div>
        <button class="clear-btn"  @click="deleteAllConversations">
          {{ trans.methods.__("clear all") }}
        </button>
      </div>
      <div class="contacts-area-block">
        <div class="contacts-area" v-for="conversation in conversations">
          <a
            class="contact-item d-block" 
                     v-bind:class="{ active: selectedConversation == conversation.id }"
            v-bind:href="conversation.id | lintToMessages"
          >
            <div
              v-bind:class="[
                $attrs.selectedconversation == conversation.id
                  ? 'media d-flex align-items-center active'
                  : 'media d-flex align-items-center',
              ]"
            >
              <div class="image-mt">
                <div class="image">
                  <img
                   
                    class="img-fluid"
                    v-bind:src="
                      conversation.receiver.image | resizeImage(50, 50)
                    "
                  />
                </div>
              </div>
              <div class="media-body">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="left-side">
                    <h6 class="text-truncate mb-0">
                      {{
                        conversation.receiver.user_type == "supplier"
                          ? $options.filters.language(conversation.receiver.supplier_name)
                          : conversation.receiver.user_name
                      }}
                    </h6>
                     <p v-if="conversation.receiver.user_type == 'supplier'">
                               {{ $options.filters.language( conversation.receiver.category.name)
                      }}
                                                                    </p>
                  </div>
                  <div class="right-side">
                    <button
                      class="close-btn"
                      @click.prevent="deleteConversation(conversation.id)"
                    >
                    <i class="fa-solid fa-circle-xmark"></i>


                      <img
                        :src="base + 'assets/front/img/close-icon.svg'"
                        alt=""
                        class="img-fluid close-icon"
                      />
                    </button>
                    <small
                      class="time"
                      v-if="Object.keys(conversation.latest_message).length > 0"
                      >{{
                        conversation.latest_message.created_at | elapsed
                      }}</small
                    >
                    <small
                      class="time"
                      v-if="
                        Object.keys(conversation.latest_message).length <= 0
                      "
                      >{{ conversation.updated_at | elapsed }}</small
                    >
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>    
  </div>
  <div v-else-if="!conversations.length > 0 && this.showConversation">
      <no-data :message="trans.methods.__('No Conversations')"></no-data>
    </div>
</div>
  
</template>

<script>
import trans from "../trans";

export default {
  name: "chats",
  props: ["selectedConversation"],
  data() {
    return {
      base: window.Laravel.base,
      loggedInUserId: window.Laravel.user_id,
      conversations: [],
      isLoading: false,
      showConversation: true,
      messages: "",
    };
  },
  mounted() {
    this.$nextTick(() => {
      setTimeout(() => {
        // console.log(`elite-chat-message-${this.loggedInUserId}`);
        Echo.channel(`fix-max-` + this.loggedInUserId).listen(
          ".new-message",
          (e) => {
            this.getMessages();
            this.getConversations();
          }
        );
      }, 500);
    });
    this.isLoading = true;
    this.getMessages();
    this.getConversations();

    setTimeout(() => {
      let messagesContainer = document.getElementById("messages-container");
      messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }, 2000);
  },
  methods: {
    getMessages(page = 1) {
      axios
        .post(`${window.Laravel.apiUrl}messages?page=` + page, {
          conversation_id: this.selectedConversation,
        })
        .then((response) => {
          if (response.data.success) {
            this.messages = response.data.data.collection;
          } else {
            console.error("Messages Error =>", response);
          }
        });
    },
    getConversations() {
      axios.get(`${window.Laravel.apiUrl}conversations`).then((response) => {
        if (response.data.success) {
          this.conversations = response.data.data.collection;
          this.isLoading = false;
          console.log(this.conversations);
        } else {
          console.error("Conversations Error =>", response);
        }
      });
      var url = window.location.href.split("/");

      if (url[6] == "conversation") {
        this.showConversation = false;
      }
      // console.log(url[6])
    },
    deleteConversation(conversationId) {
      this.$swal({
        title: trans.methods.__("Are you sure?"),
        text: trans.methods.__("Conversation will be deleted permanently."),
        type: "warning",
        showCancelButton: true,
        confirmButtonText: trans.methods.__("Yes Delete it!"),
        cancelButtonText: trans.methods.__("No, Keep it!"),
        showCloseButton: true,
        showLoaderOnConfirm: true,
      }).then((result) => {
        if (result.value)
          axios
            .get(
              `${window.Laravel.baseUrl}dashboard/conversation/` +
                conversationId +
                `/delete`
            )
            .then((response) => {
              toastr.success(
                trans.methods.__("Conversation has been deleted successfully!")
              );
              window.location.href = window.Laravel.baseUrl + "dashboard/conversations";
            });
      });
    },
    deleteAllConversations() {
      let that = this;
      var check = 0;
      this.$swal({
        title: trans.methods.__("Are you sure?"),
        text: trans.methods.__("All conversation will be deleted permanently."),
        type: "warning",
        showCancelButton: true,
        confirmButtonText: trans.methods.__("Yes Delete it!"),
        cancelButtonText: trans.methods.__("No, Keep it!"),
        showCloseButton: true,
        showLoaderOnConfirm: true,
      }).then((result) => {
        if (result.value)
          for (let conversation of that.conversations) {
            axios
              .get(
                `${window.Laravel.baseUrl}dashboard/conversation/` +
                  conversation.id +
                  `/delete`
              )
              .then((response) => {
           
                if (response.data.success == true) {
                  if (check == 0) {
                    toastr.success(
                      trans.methods.__("Success"),
                      trans.methods.__(
                        "Conversations has been deleted successfully!"
                      )
                    );
                    check = 1;
                  }
                }
                window.location.href = window.Laravel.baseUrl + "dashboard/conversations";
              });
          }
      });
    },
  },
  filters: {
    lintToMessages(value) {
      return `${window.Laravel.baseUrl}dashboard/conversation/${value}`;
    },
  },
};
</script>

<style scoped>
</style>