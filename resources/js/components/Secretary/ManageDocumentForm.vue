<template>
    <div>
        <form class="form-group"  enctype="multipart/form-data" @submit.prevent="[ (UploadProgress == null) ? UploadDocuments() : DeleteDocuments() ]">
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>المستند : {{document.name}}</h3>
                        </div>
                        <div v-if="UploadProgress" class="col-md-6 " :style="[UploadIsSuccess ? {color: 'green'} : {color : 'red'} ]">
                            <h3>عدد الملفات :
                                {{UploadedDocumentsPath.length}}
                                ,
                                {{UploadMessage}}
                            </h3>
                            <h3 v-if="UploadProgress">    {{UploadProgress }} %  </h3>
                        </div>
                        <div v-if="DeleteProgress" class="col-md-6 " :style="[DeleteIsSuccess ? {color: 'red'} : {color : 'yellow'} ]">
                            <h3>
                                عدد الملفات :
                                {{DeletedCount}}
                                ,
                                {{DeleteMessage}}
                            </h3>
                        </div>
                    </div>

                </div>
                <div class="col-md-3 justify-content-between">

                    <input type="file" ref="FileContainer" class="form-control" multiple>
                </div>
                <div class="col-md-2">
                    <button v-if="!UploadIsSuccess" class="btn btn-success btn-lg">تحميل</button>
                </div>
            </div>
        </form>
        <ol >
            <li v-for="(documentName,index) in UploadedDocumentsName">
                <a :href="DownloadDocumentLink(UploadedDocumentsPath[index])" target="_blank" >{{documentName}}</a>
            </li>
        </ol>
        <button v-if="UploadIsSuccess" @click="DeleteDocuments()" class="btn btn-danger btn-lg">حذف</button>
    </div>
</template>

<script>
    export default {
        props :{
            'document' : Object,
        },
        name : "uploadDocumentForm",
        data (){
            return{
                transaction : this.$parent.Transaction,
                //upload documents
                UploadProgress : null,
                UploadMessage: '',
                UploadIsSuccess : '',
                UploadedDocumentsPath : [],
                UploadedDocumentsName:[],
                //remove documents
                DeleteProgress : null,
                DeleteMessage: '',
                DeleteIsSuccess : '',
                DeletedCount : 0,
            }
        },
        methods : {

            UploadDocuments() {
                this.UploadProgress = 0;
                this.DeleteProgress = null;
                this.DeletedCount = 0;
                this.DeleteIsSuccess = '';
                this.uploadFiles(event => {
                    this.UploadProgress = Math.round((100 * event.loaded) / event.total);
                })
            },

            uploadFiles(onUploadProgress) {
                let formData = new FormData();

                if (this.$refs.FileContainer.files.length > 0) {

                    Array.prototype.forEach.call(this.$refs.FileContainer.files, file => {

                        formData.append("file", file);
                        return axios.post(route('TransactionDocuments.AddDocument', [this.transaction.id, this.document.id]), formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            },
                            onUploadProgress
                        })
                            .then(({data}) => {
                                this.UploadMessage = 'تم الرفع بنجاح';
                                this.UploadIsSuccess = true;
                                this.UploadedDocumentsPath.push(...data);
                                this.UploadedDocumentsName.push(file.name);
                            })
                            .catch((error) => {
                                console.log(error);
                                this.UploadMessage = 'خطأ اثناء الرفع';
                                this.UploadIsSuccess = false;
                            })
                    });
                } else {
                    this.UploadMessage = 'أختر الملف'
                    this.UploadIsSuccess = false;
                }
            },

            DeleteDocuments() {
                this.DeleteProgress = 0;
                this.UploadProgress = null;
                this.UploadIsSuccess = false;

                this.DeleteFiles()
            },

            DeleteFiles() {
                this.UploadedDocumentsPath.forEach( (FilePath, index) => {
                    let formData = new FormData();
                    formData.append("_method", 'DELETE');
                    formData.append("FilePath", FilePath);
                    return axios.post(route('TransactionDocuments.removeDocument', [this.document.id]), formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                    })
                        .then((res)=>{
                                this.DeleteMessage = 'تم الحذف';
                                this.DeleteIsSuccess = true;
                                this.DeleteProgress = 100;
                                this.DeletedCount++;

                        }).catch((error) =>{
                                console.log(error);
                                this.DeleteMessage = 'خطأ لم يتم الحذف';
                                this.DeleteIsSuccess = false;
                            });
                });
                this.UploadedDocumentsPath = [];
                this.UploadedDocumentsName = [];
            },
            DownloadDocumentLink(path){
                path = path.replace('InstitutionsDocuments/','');
                return route('TransactionDocuments.DownloadDocument',path);
            }
        }
    }
</script>

<style scoped>

</style>
