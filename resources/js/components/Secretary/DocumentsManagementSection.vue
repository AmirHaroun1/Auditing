<template>
    <div id="DocumentsUploadSection">
        <div class="box" style="margin-top: 20px">
            <div class="box-header">
                <h2>تحميل ملفات الشركة</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <upload-document-form  v-for="document in RequiredDocuments" :document="document" :key="document.id" ></upload-document-form>
                <hr>
                <div class="row">
                    <div class="col-md-12 ">
                        <button @click="NextStage()"  class="btn btn-block btn-success btn-lg" style="padding: 15px;width:230px" >  التالى</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewDocumentsUploadForm.vue",

        data () {
            return{
                Transaction : this.$parent.Transaction,
                RequiredDocuments : [],
            }
        },
        created() {
            this.fetch(route('documents.index'));
        },
        methods : {
            fetch(endpoint){
                axios.get(endpoint)
                    .then(({data}) => {
                        data.RequiredDocuments.forEach((document) => {
                            this.RequiredDocuments.push(document);
                        });
                    }).catch((error)=>{
                    console.log(error);
                })
            },
            NextStage(){
                this.$toast.success('.',
                    'قد تم رفع الملفات بنجاح '
                    ,{timout:2000});
                this.$parent.SectionStage++;
            }
        }
    }
</script>

<style scoped>

</style>
