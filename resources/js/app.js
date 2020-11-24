require('./bootstrap');

window.Vue = require('vue');
// import Echo from 'laravel-echo';
// for auto scroll
import Vue from 'vue'
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

import Message from './components/message.vue';

import User from './components/user.vue';

//Vue.component('flash', Flash);

/// for notifications
// import Toaster from 'v-toaster'
// import 'v-toaster/dist/v-toaster.css'
// Vue.use(Toaster, { timeout: 5000 })

Vue.component('message', Message);
Vue.component('user', User);


var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record
var gumStream; //stream from getUserMedia()
var rec; //Recorder.js object
var input;
new Vue({
    el: '#app',
    data: {
        message: '',
        reciver_id: 0,
        greating: '',
        my_id: 0,
        img_load: false,
        pressRecord: true,
        chat: {
            message: [],
            user: [],
            color: [],
            usersbar: [],
            records: []
        },

        username: '',
        chatName: "Public",
        domain: 'http://localhost/chatApp',
    },
    computed: {

        stylss: function() {
            return {
                backgroundColor: this.greating,
                cursor: "pointer"
            }
        },
    },
    methods: {


        getFilename(url) {
            if (url) {
                var m = url.toString().match(/.*\/(.+?)\./);
                if (m && m.length > 1) {
                    return m[1];
                }
            }
            return "";
        },
        trigger(e) {
            e.preventDefault();
            //            let element = document.getElementById("myfile");
            $("#myfile").trigger("click")


        },

        uploadfile() {
            this.chat.color.push("success");
            this.chat.user.push("you");

            let file = document.getElementById("myfile").files[0];

            var url = URL.createObjectURL(file);


            let data = { content: null, record: null, files: url }
            this.chat.message.push(data)
            let formData = new FormData();

            formData.append("file", file);

            if (this.chatName == 'Public') {
                axios.post(this.domain + '/uploadfilespublic', formData)
                    .then((response) => {
                        console.log(response);
                        // handle success
                        //    ({ response });


                    })
                    .catch((error) => {
                        // handle error
                        console.log(error);
                        (error);
                    })


            } else {
                formData.append("to_user", this.reciver_id);
                formData.append("color", 'danger');

                axios.post(this.domain + '/uploadfileprivate', formData)
                    .then((response) => {
                        console.log(response);
                        // handle success
                        //    ({ response });
                        this.message = "";

                    })
                    .catch((error) => {
                        // handle error
                        console.log(error);
                        (error);
                    })
            }



        },
        clearChat(e) {

            e.preventDefault();

            if (this.chatName == "Public") {

            } else {
                if (this.reciver_id != 0) {
                    this.chat.message = [];
                    this.chat.user = [];
                    this.chat.color = [];
                    axios.post(this.domain + '/clearchatingprivate', {
                            to_user: this.reciver_id,

                        })
                        .then((response) => {
                            console.log({ response });
                            // handle success
                            //    ({ response });


                        })
                        .catch((error) => {
                            // handle error
                            console.log(error);
                            (error);
                        })
                }

            }



        },


        startRecording(e) {

            e.preventDefault();

            /*
            	Simple constraints object, for more advanced audio features see
            	https://addpipe.com/blog/audio-constraints-getusermedia/
            */

            //   console.log(this.audioContext);

            if (this.pressRecord == true) {
                document.getElementById("record").innerText = "stop";

                var constraints = { audio: true, video: false }



                navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
                    //  console.log("getUserMedia() success, stream created, initializing Recorder.js ...");
                    //console.log(this.audioContext);

                    /*                    console.log(this.audioContext);

                        create an audio context after getUserMedia is called
                        sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
                        the sampleRate defaults to the one set in your OS for your playback device
                    */
                    //  console.log(this.audioContext);

                    audioContext = new AudioContext();


                    //update the format 
                    //   document.getElementById("formats").innerHTML = "Format: 1 channel pcm @ " + audioContext.sampleRate / 1000 + "kHz"

                    /*  assign to gumStream for later use  */
                    gumStream = stream;

                    /* use the stream */
                    input = audioContext.createMediaStreamSource(stream);
                    console.log(input);
                    /* 
                        Create the Recorder object and configure to record mono sound (1 channel)
                        Recording 2 channels  will double the file size
                    */
                    rec = new Recorder(input, { numChannels: 2 })

                    //start the recording process
                    rec.record()

                    console.log("Recording started");

                }).catch(function(err) {
                    //enable the record button if getUserMedia() fails
                    //    console.log(err);
                });

                this.pressRecord = false
            } else {
                document.getElementById("record").innerText = "record";

                //disable the stop button, enable the record too allow for new recordings
                //    console.log(this.rec);

                //tell the recorder to stop the recording
                rec.stop();

                //stop microphone access
                gumStream.getAudioTracks()[0].stop();

                //create the wav blob and pass it on to createDownloadLink
                rec.exportWAV(this.createDownloadLink);
                this.pressRecord = true;

            }

        },

        createDownloadLink(blob) {
            //            this.chat.color = [];
            this.chat.color.push("success");
            this.chat.user.push("you");

            var url = URL.createObjectURL(blob);
            var au = document.createElement('audio');
            var li = document.createElement('li');
            var link = document.createElement('a');

            //name of .wav file to use during upload and download (without extendion)
            var filename = new Date().toISOString();

            //add controls to the <audio> element
            au.controls = true;
            au.src = url;
            let data = { content: null, record: url, files: null }
            this.chat.message.push(data)
                //save to disk link
                // link.href = url;
                // link.download = filename + ".wav"; //download forces the browser to donwload the file using the  filename
                // link.innerHTML = "Save to disk";

            //add the new audio element to li
            li.appendChild(au);

            //add the filename to the li
            li.appendChild(document.createTextNode(filename + ".wav "))

            //add the save to disk link to li
            //  li.appendChild(link);

            //upload link
            var upload = document.createElement('a');
            upload.href = "#";
            upload.innerHTML = "Upload";

            var fd = new FormData();
            fd.append("audio_data", blob, filename);


            if (this.chatName == 'Public') {
                axios.post(this.domain + '/uploadrecordpublic', fd)
                    .then((response) => {
                        //   console.log(response);
                        // handle success
                        //    ({ response });


                    })
                    .catch((error) => {
                        // handle error
                        //    console.log(error);
                        (error);
                    })


            } else {
                fd.append("to_user", this.reciver_id);
                fd.append("color", 'danger');

                axios.post(this.domain + '/uploadrecordprivate', fd)
                    .then((response) => {
                        //     console.log(response);
                        // handle success
                        //    ({ response });
                        this.message = "";

                    })
                    .catch((error) => {
                        // handle error
                        //  console.log(error);
                        (error);
                    })
            }


            li.appendChild(document.createTextNode(" ")) //add a space in between
            li.appendChild(upload) //add the upload link to li

            //add the li element to the ol

            var recordingsList = document.getElementById("messages");
            //   console.log(recordingsList);
            this.valueschecking = "sasa";

            //this.chat.message.push(li)

        },

        hoverss() {

            this.greating = "#007bffbd"

        },


        blurss() {
            this.greating = ""

        },
        loadmsgs() {
            //    console.log("dddddd");
            this.img_load = true;

            this.chat.message = [];
            this.chat.user = [];
            this.chat.color = [];
            this.chatName = "Public";
            this.reciver_id = 0;
            axios.get(this.domain + '/loadmasseges')
                .then((res) => {
                    // handle success
                    //     console.log("ssssssss");
                    //   console.log(res.data);

                    res.data.allmsg.forEach(element => {

                        if (res.data.id == element.from_user) {
                            this.chat.user.push("you");
                            this.chat.color.push("success");

                        } else {
                            this.chat.user.push(element.name);
                            this.chat.color.push("danger");

                        }

                        let data = { content: element.content, record: element.record, files: element.files }
                        this.chat.message.push(data)
                    });
                    this.img_load = false;
                })
                .catch((error) => {
                    // handle error
                    //        console.log(error);
                    (error);
                })
        },

        send() {

            console.log(this.message);
            if (this.message.length != 0) {


                let data = { content: this.message, record: null, files: null }
                console.log(data);
                this.chat.message.push(data)

                // this.chat.message.push(this.message);
                this.chat.user.push("you");
                let message = this.message;
                this.message = "";
                this.chat.color.push("success");

                if (this.reciver_id != 0) {
                    (this.reciver_id)

                    //  console.log("sendprivate");

                    axios.post(this.domain + '/sendprivate', {
                            message,
                            color: "danger",
                            to_user: this.reciver_id,

                        })
                        .then((response) => {
                            //   console.log(response);
                            // handle success
                            //    ({ response });

                        })
                        .catch((error) => {
                            // handle error
                            //  console.log(error);
                            (error);
                        })
                } else {
                    // console.log("send");
                    axios.post(this.domain + '/send', {
                            message: message,
                            color: "danger"

                        })
                        .then((response) => {
                            // console.log(response);

                            // handle success
                            //(response);

                        })
                        .catch((error) => {
                            // handle error
                            //     console.log(error);

                            (error);
                        })
                }





            }
        },
        getchatfrindes(val) {
            this.img_load = true;

            this.chat.message = [];
            this.chat.user = [];
            this.chat.color = [];
            this.reciver_id = val.id;
            this.chatName = val.name;
            axios.post(this.domain + '/loadmassegesprivate', {
                    reciver_id: val.id
                })
                .then((res) => {
                    // handle success
                    //    (res.data);

                    res.data.allmsg.forEach(element => {
                        //   console.log({ me: res.data.id, mefrom: element.from_user });

                        if (res.data.id == element.from_user) {
                            this.chat.user.push("you");
                            this.chat.color.push("success");

                        } else {
                            this.chat.user.push(element.name);
                            this.chat.color.push("danger");
                            //
                        }

                        let data = { content: element.content, record: element.record, files: element.files }
                        this.chat.message.push(data)


                    });
                    this.img_load = false;

                })
                .catch((error) => {
                    // handle error
                    (error);
                })

        }
    },
    mounted() {
        // const button = this.$refs.name;

        // const name = button.dataset.names;

        // this.username = name;

        Echo.private('chat')
            .listen('ChatEvent', (e) => {

                //   console.log({ e });
                if (this.reciver_id > 0) {


                } else {

                    if (e.type == "mesage") {
                        let data = { content: e.message, record: null, files: null }
                        this.chat.message.push(data)
                    } else if (e.type == "record") {
                        let data = { content: null, record: e.message, files: null }
                        this.chat.message.push(data)
                    } else {
                        let data = { content: null, record: null, files: e.message }
                        this.chat.message.push(data)
                    }


                    this.chat.user.push(e.user);
                    this.chat.color.push("danger");
                }

            });


    },
    created() {

        axios.get(this.domain + '/loadusers')
            .then((res) => {

                res.data.forEach(element => {

                    this.chat.usersbar.push({ name: element.name, id: element.id });



                });
                (this.chat.usersbar[0].name);


            })
            .catch((error) => {
                // handle error
                (error);
            })

        this.img_load = true;

        axios.get(this.domain + '/loadmasseges')
            .then((res) => {
                // handle success
                //    console.log(res);
                ({ lool: res.data.id });


                res.data.allmsg.forEach(element => {
                    //     console.log({ element });
                    if (res.data.id == element.from_user) {
                        this.chat.user.push("you");
                        this.chat.color.push("success");

                    } else {
                        this.chat.user.push(element.name);
                        this.chat.color.push("danger");

                    }

                    //    console.log({ res });
                    let data = { content: element.content, record: element.record, files: element.files }
                    this.chat.message.push(data)



                });

                this.img_load = false;


                Echo.private('privateMessage.' + res.data.id)
                    .listen('PrivateChat', (e) => {
                        //       console.log({ reciever: this.reciver_id, user_id: e.user.id });
                        if (this.reciver_id == e.user.id) {

                            //    console.log({ e });
                            if (e.type == "mesage") {
                                let data = { content: e.message.content, record: null, files: null }
                                this.chat.message.push(data)
                            } else if (e.type == "record") {
                                let data = { content: null, record: e.message.record, files: null }
                                this.chat.message.push(data)
                            } else {

                                let data = { content: null, record: null, files: e.message.files }
                                this.chat.message.push(data)
                            }
                            //  (e.user);
                            this.chat.user.push(e.user.name);
                            this.chat.color.push("danger");

                            //     console.log({ me: res.data.id, you: this.reciver_id, user: e.user.name });

                        }


                    });
            })
            .catch((error) => {
                // handle error
                (error);
            })
    }
});