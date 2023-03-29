<template>
    <div v-bind:class="[calledPage == 'dashboard' && showNotifications ? 'col-xl-9 col-lg-8' : '']">
        <template v-if="calledPage == 'dashboard' && showNotifications">
            <div class="col-md-12">
                <div class="notification-content">
                    <div
                        class="
              title-btn-row
              d-flex
              justify-content-between
              align-items-center
            "
                    >
                        <h3 class="title">{{ trans.methods.__("Notifications") }}</h3>
                        <label class="switch">
                            <input type="checkbox" v-bind:checked="notificationSet == 1"
                                   @click="notificationSetting">
                            <span class="slider round"></span>
                        </label>
                        <button
                            type="button"
                            class="clear-btn"
                            @click="deleteMany()"
                            v-if="notifications.length > 0"
                        >
                            {{ trans.methods.__("Clear All") }}
                        </button>
                    </div>
                    <template
                        v-if="notifications.length > 0"
                        v-for="notification in notifications"
                    >
                        <div class="noti-card border-bottom pb-2">
                            <div
                                class="
                  title-img-row
                  d-flex
                  justify-content-between
                  align-content-center
                ">
                                <div class="img-title-block d-flex">
                                    <div class="noti-img-block mr-1">
                                        <img
                                            v-if="
                        notification.action == 'QUOTATION' || notification.action =='ORDER' ||
                        notification.action == 'REVIEW_SERVICE'
                      "
                                            :src="
                        (base + notification.extras.image) | resizeImage(50, 50)
                      "
                                            alt="noti-img"
                                            class="img-fluid noti-img"
                                        />
                                        <img
                                            v-else
                                            :src="
               (base + notification.sender.image) | resizeImage(78, 78)
                      "
                                            alt="noti-img"
                                            class="img-fluid noti-img"
                                        />
                                    </div>
                                    <div class="title-cate-block">
                                        <a
                                            @click="read(notification)"
                                        >
                                            <h3 class="order-name text-truncate">
                                                {{ notification.title | language }}
                                            </h3>
                                        </a>

                                        <div class="cate text-truncate"
                                             v-if="notification.extras.service_name != undefined">
                                            {{ notification.extras.service_name | language }}
                                        </div>
                                    </div>
                                </div>
                                <div class="time-block d-flex flex-column align-items-end">
                                    <button class="close-btn" @click="deleteOne(notification.id)">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="13.563"
                                            height="13.563"
                                            viewBox="0 0 13.563 13.563"
                                        >
                                            <path
                                                id="Path_48305"
                                                data-name="Path 48305"
                                                d="M7-12.031a6.573,6.573,0,0,0-3.391.916A6.852,6.852,0,0,0,1.135-8.641,6.573,6.573,0,0,0,.219-5.25a6.573,6.573,0,0,0,.916,3.391A6.852,6.852,0,0,0,3.609.615,6.573,6.573,0,0,0,7,1.531,6.573,6.573,0,0,0,10.391.615a6.852,6.852,0,0,0,2.475-2.475,6.573,6.573,0,0,0,.916-3.391,6.573,6.573,0,0,0-.916-3.391,6.852,6.852,0,0,0-2.475-2.475A6.573,6.573,0,0,0,7-12.031Zm3.336,8.559a.4.4,0,0,1,.082.246.3.3,0,0,1-.082.219L9.242-1.914a.381.381,0,0,1-.232.082.381.381,0,0,1-.232-.082L7-3.719l-1.777,1.8a.4.4,0,0,1-.246.082.3.3,0,0,1-.219-.082L3.664-3.008a.381.381,0,0,1-.082-.232.381.381,0,0,1,.082-.232l1.8-1.777-1.8-1.777a.4.4,0,0,1-.082-.246.3.3,0,0,1,.082-.219L4.758-8.586a.381.381,0,0,1,.232-.082.381.381,0,0,1,.232.082L7-6.781l1.777-1.8a.4.4,0,0,1,.246-.082.3.3,0,0,1,.219.082l1.094,1.094a.381.381,0,0,1,.082.232.381.381,0,0,1-.082.232L8.531-5.25Z"
                                                transform="translate(-0.219 12.031)"
                                                fill="#ccc"
                                            />
                                        </svg>
                                    </button>
                                    <span class="time-text">
                    {{ notification.created_at | elapsed }}
                  </span>
                                </div>
                            </div>
                            <div
                                @click="read(notification)"
                                v-html="$options.filters.language(notification.description)"
                            ></div>
                            <div
                                v-if="
                  notification.action == 'REVIEW_SUPPLIER' ||
                  notification.action == 'REVIEW_SERVICE'
                "
                            >
                                <button @click="read(notification)" class="secondary-btn">
                                    {{ trans.methods.__("Leave a Feedback") }}
                                </button>
                            </div>
                            <div
                                v-if="
                  notification.action == 'SUBSCRIPTION_REMINDER' ||
                  notification.action == 'SUBSCRIPTION' ||
                  notification.action == 'SUBSCRIPTION_EXPIRED'
                "
                            >
                                <button @click="read(notification)" class="secondary-btn">
                                    {{ trans.methods.__("Renew Now") }}
                                </button>
                            </div>
                        </div>
                    </template>
                    <template v-if="notifications.length == 0">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger w-100" role="alert">
                                    {{ trans.methods.__("no record found.") }}
                                </div>
                            </div>
                        </div>

                    </template>
                </div>
            </div>
        </template>
        <template v-if="!isLoading && calledPage == 'header'">


            <div class="notification-dd-sec">

                <template
                    v-if="notifications.length > 0"
                    v-for="notification in notifications"
                >
                    <div class="noti-card">
                        <div
                            class="
                        title-img-row
                        d-flex
                        justify-content-between
                        align-content-center
                      "
                        >
                            <div class="img-title-block d-flex">
                                <div
                                    class="noti-img-block mr-1"
                                    @click="read(notification)"
                                >
                                    <img
                                        v-if="
                           notification.action == 'QUOTATION' || notification.action =='ORDER' ||
                        notification.action == 'REVIEW_SERVICE'
                            "
                                        :src="
                              (base + notification.extras.image)
                                | resizeImage(50, 50)
                            "
                                        alt="noti-img"
                                        class="img-fluid noti-img"
                                    />
                                    <img
                                        v-else
                                        :src="
                              (base + notification.sender.image)
                                | resizeImage(50, 50)
                            "
                                        alt="noti-img"
                                        class="img-fluid noti-img"
                                    />
                                </div>
                                <div class="title-cate-block">
                                    <a
                                        @click="read(notification)"

                                    >
                                        <h3 class="order-name text-truncate">
                                            {{ notification.title | language }}
                                        </h3></a>
                                    <div class="cate text-truncate"
                                         v-if="notification.extras.service_name != undefined">
                                        {{ notification.extras.service_name | language }}
                                    </div>
                                </div>
                            </div>
                            <div
                                class="time-block d-flex flex-column align-items-end"
                            >
                                <button
                                    class="close-btn"
                                    @click="deleteOne(notification.id)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="13.563"
                                        height="13.563"
                                        viewBox="0 0 13.563 13.563"
                                    >
                                        <path
                                            id="Path_48305"
                                            data-name="Path 48305"
                                            d="M7-12.031a6.573,6.573,0,0,0-3.391.916A6.852,6.852,0,0,0,1.135-8.641,6.573,6.573,0,0,0,.219-5.25a6.573,6.573,0,0,0,.916,3.391A6.852,6.852,0,0,0,3.609.615,6.573,6.573,0,0,0,7,1.531,6.573,6.573,0,0,0,10.391.615a6.852,6.852,0,0,0,2.475-2.475,6.573,6.573,0,0,0,.916-3.391,6.573,6.573,0,0,0-.916-3.391,6.852,6.852,0,0,0-2.475-2.475A6.573,6.573,0,0,0,7-12.031Zm3.336,8.559a.4.4,0,0,1,.082.246.3.3,0,0,1-.082.219L9.242-1.914a.381.381,0,0,1-.232.082.381.381,0,0,1-.232-.082L7-3.719l-1.777,1.8a.4.4,0,0,1-.246.082.3.3,0,0,1-.219-.082L3.664-3.008a.381.381,0,0,1-.082-.232.381.381,0,0,1,.082-.232l1.8-1.777-1.8-1.777a.4.4,0,0,1-.082-.246.3.3,0,0,1,.082-.219L4.758-8.586a.381.381,0,0,1,.232-.082.381.381,0,0,1,.232.082L7-6.781l1.777-1.8a.4.4,0,0,1,.246-.082.3.3,0,0,1,.219.082l1.094,1.094a.381.381,0,0,1,.082.232.381.381,0,0,1-.082.232L8.531-5.25Z"
                                            transform="translate(-0.219 12.031)"
                                            fill="#ccc"
                                        />
                                    </svg>
                                </button>
                                <span class="time-text">
                          {{ notification.created_at | elapsed }}</span
                                >
                            </div>
                        </div>
                        <div
                            @click="read(notification)"
                            v-html="
                        $options.filters.language(notification.description)
                      "
                        ></div>
                        <div
                            v-if="
                        notification.action == 'REVIEW_SUPPLIER' ||
                        notification.action == 'REVIEW_SERVICE'
                      "
                        >
                            <button @click="read(notification)" class="secondary-btn">
                                {{ trans.methods.__("Leave a Feedback") }}
                            </button>
                        </div>
                        <div
                            v-if="
                        notification.action == 'SUBSCRIPTION_REMINDER' ||
                        notification.action == 'SUBSCRIPTION' ||
                        notification.action == 'SUBSCRIPTION_EXPIRED'
                      "
                        >
                            <button @click="read(notification)" class="secondary-btn">
                                {{ trans.methods.__("Renew Now") }}
                            </button>
                        </div>
                    </div>
                </template>
                <template v-if="notifications.length == 0">

                    <div class="alert alert-danger w-100" role="alert">
                        {{ trans.methods.__("no record found.") }}
                    </div>

                </template>

            </div>


            <div class="chat-btn-row d-flex align-items-center justify-content-between">
                <div class="shipping-heading-btn-head w-100">
                    <a
                        class="primary-btn w-100 h-45 mw-100"
                        :href="baseUrl + 'dashboard/notification'"
                        v-if="notifications.length > 0"
                    >
                        {{ trans.methods.__("View All") }}
                    </a>
                </div>
                <button
                    type="button"
                    class="secondary-btn"
                    @click="deleteMany()"
                    v-if="notifications.length > 0"
                >
                    {{ trans.methods.__("Clear All") }}
                </button>
            </div>
        </template>
    </div>
</template>
<script>
export default {
    name: "notifications",
    props: ["class1", "class2", "calledfrom", "currentpagenumber", "usersettings"],
    data() {
        return {
            baseUrl: window.Laravel.baseUrl,
            loggedInUserId: window.Laravel.user_id,
            calledPage: this.calledfrom,
            notificationSet: this.usersettings,
            notifications: [],
            isLoading: false,
            showNotifications: false,
            base: window.Laravel.base,
        };
    },
    created() {
        console.log("Created");
        this.setSocketListeners();
        if (this.calledPage == "dashboard") {
            this.seenAll();
        }
        this.isLoading = true;
        this.list();
    },
    mounted() {
        console.log(this.loggedInUserId, "id");
    },
    methods: {
        setSocketListeners() {
            Echo.channel(`fix-max-` + this.loggedInUserId).listen(
                ".new-notification",
                (e) => {
                    // this.seenAll()
                    if (this.calledPage == "dashboard") {
                        this.seenAll();
                    }
                    this.list();
                    console.log(e);
                }
            );
        },
        list() {
            axios
                .get(`${window.Laravel.apiUrl}notifications`, {
                    params: {page: this.currentpagenumber},
                })
                .then((response) => {
                    if (response.data.success) {
                        console.log("44444");
                        this.notifications = response.data.data.collection;
                        this.isLoading = false;
                        this.showNotifications = true;
                        this.$emit("notifications-loaded", true);
                    } else {
                        console.error("Notifications Error =>", response);
                    }
                });
        },
        seenAll() {
            axios
                .get(`${window.Laravel.apiUrl}notification-seen`)
                .then((response) => {
                    if (response.data.success) {
                        // this.list()
                    } else {
                        console.error("Seen Notifications Eerror =>", response);
                    }
                });
        },
        read(data) {
            axios
                .get(`${window.Laravel.apiUrl}notification-view/${data.id}`)
                .then((response) => {
                    if (response.data.success) {
                        /*console.log(data.action)
                                    console.log(data, response.data)
                                    debugger*/
                        if (data.action === "QUOTATION") {
                            window.location = `${window.Laravel.baseUrl}dashboard/quotation/${data.extras.quotation_id}/detail`;
                        }
                        if (data.action === "ORDER") {
                            console.log(data.extras);
                            window.location = `${window.Laravel.baseUrl}dashboard/order/${data.extras.order_id}/detail`;
                        }
                        if (data.action === "REVIEW_SERVICE") {
                            window.location = `${window.Laravel.baseUrl}service/${data.extras.service_slug}/detail`;
                        }
                        if (data.action === "REVIEW_SUPPLIER") {
                            window.location = `${window.Laravel.baseUrl}supplier/detail/${data.extras.supplier_id}`;
                        }

                        if (data.action === "SUPPLIER_REVIEWED") {
                            window.location = `${window.Laravel.baseUrl}dashboard/reviews`;
                        }
                        if (data.action === "SERVICE_REVIEWED") {
                            window.location = `${window.Laravel.baseUrl}service/${data.extras.service_slug}/detail`;
                        }
                        if (data.action === "OPEN_CONVERSATION") {
                            window.location = `${window.Laravel.baseUrl}dashboard/conversation/${data.extras.conversation_id}`;
                        }
                        if (
                            data.action === "SUBSCRIPTION_REMINDER" ||
                            data.action === "SUBSCRIPTION_EXPIRED"
                        ) {
                            window.location = `${window.Laravel.baseUrl}dashboard/subscription-packages`;
                        }

                        if (data.action === "WITHDRAW") {
                            window.location = `${window.Laravel.baseUrl}dashboard/payment/profile`;
                        }
                    } else {
                        console.error("Seen Notifications Error =>", response);
                    }
                });
        },
        getTimeCreatedTime(unix) {
            return moment.unix(unix).format("h:mm a");
        },
        deleteOne(id) {
            let that = this;
            swal(
                {
                    title: that.trans.methods.__("Are you sure you want to delete this?"),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1C4670",
                    confirmButtonText: that.trans.methods.__("Delete"),
                    cancelButtonText: that.trans.methods.__("No"),
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true,
                },
                function (isConfirm) {
                    if (isConfirm) {
                        axios
                            .post(`${window.Laravel.apiUrl}notification-delete`, {
                                notifications: [id],
                            })
                            .then((response) => {
                                if (response.data.success) {
                                    // console.log(that.calledPage)
                                    toastr.success(
                                        that.trans.methods.__("Success"),
                                        that.trans.methods.__(
                                            "Notification has been deleted successfully!"
                                        )
                                    );
                                    if (that.calledPage == "dashboard") {
                                        location.reload();
                                        // window.location = `${window.Laravel.baseUrl}dashboard/notifications`;
                                    } else if (that.calledPage == "header") {
                                        location.reload();
                                    } else {
                                        that.list();
                                    }
                                } else {
                                    console.error("Notifications Error =>", response);
                                }
                            });
                    } else {
                        swal.close();
                    }
                }
            );

        },
        ChangeSiteSettingAlert() {
            let that = this;
            swal({
                title: that.trans.methods.__('Are you sure you want to update setting?'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1C4670",
                confirmButtonText: that.trans.methods.__('Yes'),
                cancelButtonText: that.trans.methods.__('No'),
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    axios.get(`${window.Laravel.apiUrl}set/user/settings`)
                        .then(response => {
                            if (response.data.success) {
                                console.log("this is response data", response, response.data.data.collection.settings);
                                this.notificationSet = response.data.data.collection.settings;
                                // toastr.success(this.trans.methods.__('Success'), this.trans.methods.__("Setting updated successfully"));
                                location.reload();
                            } else {
                                console.error('Notifications Error =>', response)
                            }
                        })
                } else {
                    this.notificationSet = 0;
                    swal.close();
                    location.reload();
                }
            })

        },

        deleteMany() {
            let that = this;
            swal(
                {
                    title: that.trans.methods.__("Are you sure you want to delete all the notifications?"),
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1C4670",
                    confirmButtonText: that.trans.methods.__("Delete"),
                    cancelButtonText: that.trans.methods.__("No"),
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true,
                },
                function (isConfirm) {
                    if (isConfirm) {
                        axios
                            .post(`${window.Laravel.apiUrl}notification-delete`, {
                                notifications: [],
                            })
                            .then((response) => {
                                if (response.data.success) {
                                    toastr.success(
                                        that.trans.methods.__(
                                            "All Notifications has been deleted successfully!"
                                        )
                                    );
                                    if (that.calledPage == "dashboard") {
                                        location.reload();
                                        // window.location = `${window.Laravel.baseUrl}dashboard/notifications`;
                                    } else if (that.calledPage == "header") {
                                        location.reload();
                                    }
                                    that.list();
                                } else {
                                    console.error("Notifications Error =>", response);
                                }
                            });
                    } else {
                        swal.close();
                    }
                }
            );
        },

        notificationSetting() {
            this.ChangeSiteSettingAlert();
        }
    },
};
</script>

<style scoped>
a {
    cursor: pointer;
}
</style>
