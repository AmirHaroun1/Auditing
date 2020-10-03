<template>
    <div>

        <!-- Find Trade Register Section -->
            <div id="SearchTradeRegister">
                <div class="row">
                    <div class="col-md-12">
                        <h3>أدخل رقم السجل الرئيسي للمنشأة</h3>
                            <input class="form-control" v-model="TradeRegisterInput" type="number">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button @click="SearchTradeRegister()" class="btn btn-block btn-lg btn-success" style="margin-top: 10px">التالي</button>
                    </div>
                </div>

            </div>
        <!-- /.Find Trade Register Section -->

        <!-- New Company Section -->
        <div  id="NewCompany" style="padding-top:20px">
            <div class="row">
                <div class="col-md-12">


                    <!-- ٍStages Count Section -->
                    <div id="StagesCount" style="padding-bottom: 70px" >
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-2 ">
                                    <div :class="[ (this.NewCompanySectionStage == 1) ? ActiveCircle : NonActiveCircle]" >1</div>
                                </div>
                                <div class="col-md-10">
                                    <h4 class="text-center" :class="[(this.NewCompanySectionStage == 1) ? ActiveHeading : '']">بيانات الشركة</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <div class="row">
                                <div class="col-md-2">
                                    <div :class="[ (this.NewCompanySectionStage == 2) ? ActiveCircle : NonActiveCircle]">2</div>
                                </div>
                                <div class="col-md-10">
                                    <h4 class="text-center" :class="[(this.NewCompanySectionStage == 2) ? ActiveHeading : '']">ظابط الأتصال</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 ">
                            <div class="row">
                                <div class="col-md-2">
                                    <div :class="[ (this.NewCompanySectionStage == 3) ? ActiveCircle : NonActiveCircle]">3</div>
                                </div>
                                <div class="col-md-10">
                                    <h4 class="text-center" :class="[(this.NewCompanySectionStage == 3) ? ActiveHeading : '']">تحميل المستندات</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <div class="row">
                                <div class="col-md-2">
                                    <div :class="[ (this.NewCompanySectionStage == 4) ? ActiveCircle : NonActiveCircle]">4</div>
                                </div>
                                <div class="col-md-10">
                                    <h4 class="text-center" :class="[(this.NewCompanySectionStage == 4) ? ActiveHeading : '']">شاشة الدفع</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <div class="row">
                                <div class="col-md-2">
                                    <div :class="[ (this.NewCompanySectionStage == 5) ? ActiveCircle : NonActiveCircle]">6</div>
                                </div>
                                <div class="col-md-10">
                                    <h4 class="text-center" :class="[(this.NewCompanySectionStage == 5) ? ActiveHeading : '']">طبع الخطاب</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./Stages Count Section -->


                    <div v-if="NewCompanySectionStage == 1" id="NewCompany_TransactionFirstStage">
                        <new-company-form></new-company-form>
                    </div>
                    <div v-else-if="NewCompanySectionStage == 2" id="NewAgent_TransactionSecondStage">
                        <new-agent-form></new-agent-form>
                    </div>
                    <div v-else-if="NewCompanySectionStage == 3" id="NewDocuments_TransactionFourthStage">
                        <new-documents-upload-form></new-documents-upload-form>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.New Company Section -->

        <!-- /.Existing Company Section -->
        <div v-if="ExistingCompany" id="ExistingCompanyContent">
            <div class="col-md-12">
                <div class="collapse" id="ExistingCompany">
                    <div class="card card-body">
                        existing company
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Existing Company Section -->


    </div>

</template>


<script>
    import  {NewCompanyForm} from './NewCompanyForm.vue';
    import  {NewAgentForm} from './NewAgentForm.vue';
    export default {
        data()
        {
            return {

                TradeRegisterInput: '',

                TradeRegister : null,
                NewCompany : false,
                ExistingCompany : false,

                NewCompanySectionStage: 3,
                New_institution: Object,

                New_Transaction : Object,

                NonActiveCircle: {
                    'numberCircle': true,
                },
                ActiveCircle: {
                    'activeNumberCircle': true,
                },
                ActiveHeading: {
                    'activeNumberHeading': true,
                },

            }
        },
        name: "NewTransaction.vue",
        methods:{
            SearchTradeRegister(){

                axios.get(route('TradeRegister.search',this.TradeRegisterInput))
                    .then(({data}) => {
                        if( data.TradeRegister[0]){
                            this.TradeRegister = data.TradeRegister[0];
                            this.ExistingCompany = true;
                        }else{
                            this.NewCompany = true;
                        }

                    })
                    .catch((error) =>{
                        console.log(error);
                    })
            }
        }
    }
</script>

<style scoped>

</style>
