<template>
    <div id="DocumentsUploadSection">
        <div class="box" style="margin-top: 20px">
            <div class="box-header">
                <h2>تحميل ملفات الشركة</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewDocumentsUploadForm.vue",

        data () {
            return{
                RequiredDocuments : [],
                UploadedFiles : [],
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
                    })
            },
        }
    }
</script>

<style scoped>

</style>
