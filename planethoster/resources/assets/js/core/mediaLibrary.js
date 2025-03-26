// mgJsComponentHandler.addDefaultComponent('mg-medialibrary', {
//     template : '#t-mg-medialibrary',
//     props: [
//         'component_id',
//         'component_namespace',
//         'component_index',
//         'gallery_path',
//         'remove_button_namespace',
//         'remove_button_id',
//         'modal_button_namespace',
//         'modal_button_id'
//     ],
//     data : function() {
//         return {
//             availableGraphics: [],
//             targetUrl: mgUrlParser.getCurrentUrl(),
//             defaultImage: "img-container.svg",
//             removeButtonNamespace: null,
//             removeButtonId: null,
//             modalButtonNamespace: null,
//             modalButtonId: null
//         };
//     },
//     created: function () {
//         console.log("Zadziałało");
//         this.loadAvailableGraphics();
//         this.initRemoveButton();
//         this.initModalButton();
//         this.$parent.$root.$on('reloadMgData', this.updateMgData);
//         $('.lu-app').addClass('lu-app--media-manager');
//     },
//     updated: function (){
//
//     },
//     methods: {
//         updateMgData: function (toReloadId) {
//             var self = this;
//             if (self.component_id === toReloadId) {
//                 self.loadAvailableGraphics();
//                 self.$nextTick(function () {
//                     self.$emit('restartRefreshingState');
//                 });
//             }
//         },
//         getAvailableGraphics: function () {
//             return (typeof this.availableGraphics != 'undefined') ? this.availableGraphics : [];
//         },
//         getImageFullUrl: function () {
//             return this.gallery_path + this.image_name;
//         },
//         getImageUrlWithName: function (name) {
//             return this.gallery_path + name;
//         },
//         deleteSelectedImage: function () {
//             this.image_name = '';
//         },
//         loadAvailableGraphics: function () {
//             var self = this;
//             self.loading = true;
//
//             var requestParams = {
//                 loadData: self.component_id,
//                 namespace: self.component_namespace,
//                 index: self.component_index,
//             };
//
//             var response = self.$parent.$root.$options.methods.vloadData(requestParams);
//
//             return response.done(function (data) {
//                 if (data['images']) {
//                     Object.entries(data['images']).forEach(item => {
//                         if (item[1] === self.defaultImage) {
//                             delete data['images'][item[0]]
//                         }
//                     })
//                 }
//                 self.availableGraphics = data['images'];
//             }).fail(function () {
//                 console.log("failed");
//             }).then(() => {
//                 self.loading = false;
//             });
//         },
//         initRemoveButton: function () {
//             var self = this;
//
//             this.removeButtonNamespace = self.remove_button_namespace;
//             this.removeButtonId = self.remove_button_id;
//         },
//         initModalButton: function () {
//             var self = this;
//
//             this.modalButtonNamespace = self.modal_button_namespace;
//             this.modalButtonId = self.modal_button_id;
//         },
//         buttonAction: function (event) {
//             var self = this;
//             this.loadModal(event, self.component_id, this.modalButtonNamespace, this.modalButtonId, null, true);
//         },
//         selectImage: function(imageName) {
//             this.image_name = imageName;
//         },
//         setFileNameInInput: function() {
//             input = $("#fileInputContainer input")[0];
//             if (typeof input != 'undefined') {
//                 imageName = document.getElementById("imageName")
//                 inputImage = input.files[0];
//                 imageName.innerText = inputImage.name;
//             }
//         },
//         emptyGallery: function() {
//             return this.availableGraphics ? this.availableGraphics.length == 0 : true;
//         },
//         loadImageRemoveModal: function (event, targetId) {
//             var self = this;
//             mgPageControler.vueLoader.loadModal(event, targetId,
//                 this.removeButtonNamespace, this.removeButtonId, [{id: targetId}], false);
//         },
//         refreshUrl: function () {
//             var self = this;
//             self.targetUrl = mgUrlParser.getCurrentUrl();
//             if (self.targetUrl.indexOf('#') > 0) {
//                 self.targetUrl = self.targetUrl.substr(0, self.targetUrl.indexOf('#'));
//             }
//         },
//         loadModal: function(event, targetId, namespace, index) {
//             mgPageControler.vueLoader.loadModal(event,targetId, namespace, index, null, false);
//         },
//     }
// });