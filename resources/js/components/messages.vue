<template>
  <div class="messages font-dosis font-16 hdn" v-if="!isLoading">
    <div class="messages-content">
      <div class="messages-area" id="messages-container">
        <div v-for="message in messages">
          <div
            class="d-flex float-right mt-3 justify-content-end"
            v-if="message.sender_id == loggedInUserId"
          >
            <div class="my-msg Oswald-Light mt-0">
              <span v-if="message.message && message.message.length"
                >{{ message.message }}
              </span>
              <a
                :href="message.file"
                data-lightbox="trade-photo"
                v-if="message.mime_type == 'file'"
              >
                <img
                  v-if="message.mime_type == 'file'"
                  class="img-fluid"
                  v-bind:src="message.file"
                />
              </a>
              <span class="received-time">{{ message.date }} {{ message.created_at | timeConversion }}</span>
            </div>
          </div>
          <div class="clearfix"></div>
          <div
            class="sender-msg media"
            v-if="message.sender_id != loggedInUserId"
          >
            <div class="d-flex">
              <div class="my-chat-img mr-1">
                <img
                  :src="
                    conversationObject.receiver.image != null
                      ? $options.filters.resizeImage(
                          conversationObject.receiver.image,
                          60,
                          60
                        )
                      : conversationObject.receiver.image_url
                  "
                  alt="chat-img"
                  class="img-fluid"
                />
              </div>
              <div class="media-body Oswald-Light">
                <div class="small-message smallmessage">
                  <div class="single-msg">
                    <span v-if="message.message && message.message.length">{{
                      message.message
                    }}</span>
                  </div>
                    <div
                      class="chat-large-img"
                      v-if="message.mime_type == 'file'"
                    >
                      <a
                        :href="message.file"
                        data-lightbox="trade-photo"
                        v-if="message.mime_type == 'file'"
                      >
                        <img v-bind:src="message.file" class="img-fluid" />
                      </a>
                    </div>
                  <span class="send-time OpenSans-Regular text-left">{{ message.date }} {{
                    message.created_at | timeConversion
                  }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <form>
        <div class="msg-form">
          <div class="position-relative msg-form-mt">
            <input
              type="text"
              name="content"
              class="form-control"
              :placeholder="trans.methods.__('Write  Message...')"
              v-model="form.message"
              @input="isMessageContainsVal"
            />
            <button
              class="btn-primary border-0"
              @click.prevent="sendMessage"
              :disabled="formSubmitted || isMessageEmpty"
            >
              <i
                class="fas fa-arrow-right btn-icon-chat"
                v-if="!formSubmitted"
              ></i>
              <i
                class="fas fa-spinner fa-spin btn-icon-chat"
                v-if="formSubmitted"
              ></i>
            </button>
            <div class="input-file mr-1">
              <label
                for="file-upload-caht"
                class="my-file-upload-chat"
                v-if="!imageUploading"
              >
                <button
                  type="button"
                  class="file-upload-clip"
                  @click="triggerUploadFileInput()"
                >
                  <img
                    :src="base + 'assets/front/img/clip-icon.svg'"
                    alt="clip"
                  />
                </button>
                <input
                  type="file"
                  id="file-upload-caht"
                  class="d-none"
                  accept="image/*"
                  @change="uploadFile"
                />
              </label>
              <div class="chat-loader" v-if="imageUploading">
                <span class="chat-loader-count">{{ this.progress }}</span>
                <i class="fas fa-spinner fa-spin btn-icon-chat"></i>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="top-info" v-if="conversationObject != null">
        <div class="product-info d-flex align-items-center">
          <div class="image mr-3">
            <img
              v-if="Object.keys(conversationObject.service).length > 0"
              class="img-fluid"
              v-bind:src="
                conversationObject.service.default_image | resizeImage(59, 59)
              "
            />
            <img
              v-if="Object.keys(conversationObject.service).length <= 0"
              class="img-fluid"
              v-bind:src="
                conversationObject.receiver.image | resizeImage(59, 59)
              "
            />
          </div>
          <div class="body w-100">
            <div
              class="
                product-info-chat-2nd
                d-flex
                align-items-start
                justify-content-between
              "
            >
              <div class="title-sub-title">
                <p
                  class="mb-0 title text-truncate"
                  v-if="Object.keys(conversationObject.service).length > 0"
                >
                  {{ $options.filters.language(conversationObject.service.name) }}
                </p>
                <p
                  class="mb-0 title text-truncate"
                  v-if="Object.keys(conversationObject.service).length <= 0"
                >
                  {{
                    conversationObject.receiver.user_type == "supplier"
                      ? $options.filters.language(conversationObject.receiver.supplier_name)
                      : conversationObject.receiver.user_name
                  }}
                </p>
                <h3
                  class="price text-truncate"
                  v-if="Object.keys(conversationObject.service).length > 0"
                >
                  <span
                    v-if="conversationObject.service.service_type == 'offer'"
                  >
                    {{trans.methods.__('AED')}} {{ conversationObject.service.discounted_min_price }} -
                    {{trans.methods.__('AED')}}{{
                      conversationObject.service.discounted_max_price
                    }}</span
                  >
                  <span v-else>
                    {{trans.methods.__('AED')}}{{ conversationObject.service.min_price }} - {{trans.methods.__('AED')}}{{
                      conversationObject.service.max_price
                    }}</span
                  >
                </h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import trans from "../trans";

export default {
  name: "messages",
  props: ["conversation"],
  data() {
    return {
      // conversationId: this.conversationId,
      isLoading: false,
      loggedInUserId: window.Laravel.user_id,
      base: window.Laravel.base,
      conversationObject: null,
      messages: [],
      form: {
        message: "",
        file: "",
        mime_type: "text",
        conversation_id: 0,
      },
      formSubmitted: false,
      imageUploading: false,
      isMessageEmpty: true,
      page: 1,
      isConversationHaveMessages: true,
      progress: 0,
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.isLoading = true;
      this.socketListners();
      this.getConversation();
      this.getMessages(this.page);
    });
  },
  methods: {
    getConversation() {
      axios
        .post(`${window.Laravel.apiUrl}start-conversation`, {
          id: this.conversation,
        })
        .then((response) => {
          if (response.data.success) {
            this.conversationObject =
              response.data.data.collection.conversation;
            console.log(this.conversationObject, 35455);
            this.isLoading = false;
          } else {
            console.error("Conversations Error =>", response);
          }
        });
    },
    getMessages(page) {
      axios
        .post(`${window.Laravel.apiUrl}messages?page=` + page, {
          conversation_id: this.conversation,
        })
        .then((response) => {
          if (response.data.success) {
            // this.messages = response.data.data.collection
            let messages = [];
            $.each(response.data.data.collection, function (i, names) {
              messages.push(names);
            });
            if (this.messages.length > 0) {
              this.messages = messages.concat(this.messages);
            } else {
              this.messages = messages.reverse();
              this.moveMessagesBoxDown();
            }
            if (response.data.data.pagination.last_page > this.page) {
              this.page++;
            } else {
              this.isConversationHaveMessages = false;
            }
          } else {
            console.error("Messages Error =>", response);
          }
        });
    },
    sendMessage() {
      // var str = "    ";

      this.formSubmitted = true;
      this.form.conversation_id = this.conversationObject.id;
      // console.log(this.form)
      axios
        .post(`${window.Laravel.apiUrl}send-message`, this.form)
        .then((response) => {
          let message = response.data.data.collection;
          this.messages.push({...message});
          this.formSubmitted = false;
          this.resetMessageForm();
          this.moveMessagesBoxDown();
          this.isMessageContainsVal();
        });
    },
    resetMessageForm() {
      this.form = {
        message: "",
        file: "",
        mime_type: "text",
        conversation_id: 0,
      };
    },
    triggerUploadFileInput() {
      $("#file-upload-caht").click();
    },
    uploadFile(event) {
      let that = this;
      this.imageUploading = true;
      let image = event.target.files[0];
      let formData = new FormData();
      formData.append("image", image, image.name);
      axios
        .post(`${window.Laravel.apiUrl}upload-image`, formData, {
          onUploadProgress: function (progressEvent) {
            // console.log('progressEvent =>',progressEvent);
            const totalLength = progressEvent.lengthComputable
              ? progressEvent.total
              : progressEvent.target.getResponseHeader("content-length") ||
                progressEvent.target.getResponseHeader(
                  "x-decompressed-content-length"
                );
            // console.log("onUploadProgress", totalLength);
            // console.log('percentCompleted value =>', Math.round( (progressEvent.loaded * 100) / progressEvent.total ));

            if (totalLength !== null) {
              that.progress = Math.round(
                (progressEvent.loaded * 100) / totalLength
              );
              // console.log('progress value =>', Math.round( (progressEvent.loaded * 100) / totalLength ))
              // this.updateProgressBarValue();
            }
          },
        })
        .then((response) => {
          console.log(response.data);
          if (response.data.success == false) {
            toastr.error(trans.methods.__("Error"), response.data.message);
            this.formSubmitted = false;
            this.imageUploading = false;
          } else {
            this.form.file = response.data.data.collection.file_name;
            this.form.mime_type = "file";
            this.imageUploading = false;
            this.sendMessage();
          }
        });
    },
    isDisabled() {
      if (this.formSubmitted == false && this.imageUploading == false) {
        return false;
      } else {
        return true;
      }
    },
    moveMessagesBoxDown() {
      setTimeout(() => {
        let messagesContainer = document.getElementById("messages-container");
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        console.log(
          messagesContainer.scrollTop,
          messagesContainer.scrollHeight
        );
      }, 500);
    },
    // socketListners(){
    //   Echo.channel(`elite-chat-message-`+this.loggedInUserId)
    //       .listen('.new-message', (e) => {
    //         // if(e.message.sender_id != this.loggedInUserId && this.conversation == e.message.conversation_id){
    //         if(this.conversation == e.message.conversation_id){
    //         this.messages.push({...e.message});
    //         }
    //         this.moveMessagesBoxDown()
    //       });
    // },
 socketListners() {
      Echo.channel(`fix-max-` + this.loggedInUserId).listen(
        ".new-message",
        (e) => {
          if (
            e.message.sender_id != this.loggedInUserId &&
            this.conversation == e.message.conversation_id
          ) {
            this.messages.push({ ...e.message });
          }
          this.moveMessagesBoxDown();
        }
      );
    },
    // socketListners() {
    //   Echo.channel(`fix-max-` + this.loggedInUserId).listen(
    //     ".new-message",
    //     (e) => {
    //       if (this.conversationObject.id === e.message.conversation_id) {
    //         // this.messages.push({ ...e.message });
    //       }
    //       this.moveMessagesBoxDown();
    //     }
    //   );
    // },
    isMessageContainsVal() {
      if (
        this.form.message === "" ||
        !this.form.message.replace(/\s/g, "").length
      ) {
        this.isMessageEmpty = true;
      } else {
        this.isMessageEmpty = false;
      }
    },
  },
};
</script>
