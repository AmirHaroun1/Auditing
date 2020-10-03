<template>

    <div class="box" style="margin-top: 20px">
        <div class="box-header">
            <h2 class="pb-3">أضافة منشأة جديدة</h2>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form class="form-group" @submit.prevent="createBranchedRegisters()">
            <!-- New TransAction Form Content ------>
                <div class="row">
                    <div class="form-group col-md-6" style="padding-bottom: 20px" >
                        <label class="float-right">رقم السجل رئيسي</label>
                        <input v-model="MainTradeRegister.number" type="number" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6" style="padding-bottom: 20px" required>
                        <label class="float-right">السنة المالية</label>

                        <input v-model="transaction.FinancialYear" type="number" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <h4 class="box-header">بيانات السنة المالية</h4>
                    <div class="form-group col-md-6" style="padding-bottom: 20px">
                        <label class="float-right">بداية السنة المالية</label>

                        <input v-model="transaction.start_financial_year" type="date" class="form-control" required>

                    </div>
                    <div class="form-group col-md-6" style="padding-bottom: 20px">
                        <label class="float-right">نهاية السنة المالية</label>

                        <input v-model="transaction.end_financial_year" type="date" class="form-control" required>

                    </div>
                </div>
                <div class="row">
                    <h4 class="box-header">بيانات الفترة المالية</h4>
                    <div class="form-group col-md-6" style="padding-bottom: 20px">
                        <label class="float-right">بداية الفترة المالية</label>

                        <input v-model="transaction.start_financial_period" type="date" class="form-control" required>

                    </div>
                    <div class="form-group col-md-6" style="padding-bottom: 20px">
                        <label class="float-right">نهاية الفترة المالية</label>

                        <input v-model="transaction.end_financial_period" type="date" class="form-control" required>

                    </div>
                </div>


                <div class="row">
                    <h4 class="box-header">بيانات السجل الرئيسي</h4>
                    <div class="form-group col-md-6" style="padding-bottom: 20px">
                        <label class="float-right"> مكان صدور السجل الرئيسى</label>

                        <input v-model="MainTradeRegister.production_place" type="text" class="form-control" required >
                    </div>


                    <div class="form-group col-md-6" style="padding-bottom: 20px">
                        <label class="float-right">تاريخ السجل الرئيسى</label>

                        <input v-model="MainTradeRegister.date" type="date" class="form-control" required>

                    </div>
                </div>

                <div class="row">
                    <h3 class="box-header">السجلات الفرعية</h3>
                    <div class="col-md-5">
                        <label class="float-right">رقم السجل الفرعى</label>
                        <input type="number" v-model="BranchedTradeRegister.number" class="form-control" >
                    </div>
                    <div class="col-md-4">
                        <label class="float-right">مكان صدور السجل الفرعى</label>
                        <input type="text" v-model="BranchedTradeRegister.production_place" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="float-right"> تاريخ السجل الفرعى</label>
                        <input type="date"  v-model="BranchedTradeRegister.date" class="form-control" >
                    </div>

                    <div class="col-md-3">
                        <a @click="AddRegisterToList()" class="btn btn-success btn-lg" style="margin-top:5px">أضافة سجل</a>
                    </div>

                    <div v-if="AddedBranchedRegisters.length" class="col-md-12">
                        <table class="table" style="margin-top:10px">
                            <tbody><tr>
                                <th>رقم السجل</th>
                                <th>تاريخ السجل</th>
                                <th>مكان الصدور</th>
                                <th>حذف</th>
                            </tr>
                            <tr v-for="reg in AddedBranchedRegisters">
                                <td>{{reg.number}}</td>
                                <td>{{reg.date}}</td>
                                <td>
                                   {{reg.production_place}}
                                </td>
                                <td><i class="fa fa-times" style="color:red;cursor:pointer;" @click="removeRegisterFromList(reg)"></i></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            <!-- /.New TransAction Form Content ------>

            <!-----Create-Institution Form Content -->

                <div class="row" id="NewCompanyInformation">
                        <h3 class="box-header"> بيانات المنشأة</h3>
                        <div class="col-lg-6" style="padding-bottom: 20px">
                            <label class="float-right">الأسم</label>
                            <input v-model="institution.name" type="text" class="form-control" required >
                        </div>
                        <div class="col-lg-6" style="padding-bottom: 20px">
                            <label class="float-right">رقم الشركة</label>
                            <input v-model="institution.company_number" type="number" class="form-control" required >
                        </div>
                        <div class="col-lg-3" style="padding-bottom: 20px">
                            <label class="float-right">الكيان القانوني</label>
                            <select class="form-control" v-model="institution.legal_entity" required >
                                <option disabled></option>
                                <option value="شركة ذات مسؤولية محدودة">الكيان القانوني1</option>
                                <option value="مؤسسة فردية سعودية">الكيان القانوني2</option>
                                <option value="شركة مساهمة ">الكيان القانوني3</option>
                            </select>
                        </div>
                        <div class="col-lg-3" style="padding-bottom: 20px">
                            <label class="float-right">اهتمامات الملاك</label>
                            <select class="form-control" v-model="institution.angel_interests" required>
                                <option disabled></option>
                                <option value="شركة ذات مسؤولية محدودة">اهتمامات الملاك1</option>
                                <option value="مؤسسة فردية سعودية">اهتمامات الملاك2</option>
                                <option value="شركة مساهمة ">اهتمامات الملاك3</option>
                            </select>
                        </div>
                        <div class="col-lg-4" style="padding-bottom: 20px">
                            <label class="float-right">طبيعة ملكية المنشأة وكيفية تمويلها</label>
                            <select class="form-control" v-model="institution.nature" required >
                                <option disabled ></option>
                                <option value="شركة ذات مسؤولية محدودة">اختيار1</option>
                                <option value="مؤسسة فردية سعودية">اختيار2</option>
                                <option value="شركة مساهمة ">اختيار3</option>
                            </select>
                        </div>
                        <div class="col-md-9" style="padding-bottom: 20px">
                            <label class="float-right">نشاط المنشأة</label>
                            <textarea class="form-control" v-model="institution.business_activity" rows="6" required >

                            </textarea>
                        </div>
                        <div class="col-lg-4" style="padding-bottom: 20px">
                            <label class="float-right mt-2">العنوان: المدينة</label>
                            <select class="form-control" v-model="institution.city" required>
                                <option disabled></option>
                                <option value="مدينة1">مدينة1</option>
                                <option value="مدينة2">مدينة2</option>
                                <option value="مدينة3">مدينة3</option>
                            </select>
                        </div>
                        <div class="col-lg-4" style="padding-bottom: 20px">
                            <label class="float-right mt-2">العنوان: الحى</label>
                            <select class="form-control" v-model="institution.district" required >
                                <option disabled></option>
                                <option value="حي1">حي1</option>
                                <option value="حي2">حي2</option>
                                <option value="حي3">حي3</option>
                            </select>
                        </div>
                        <div class="col-lg-4" style="padding-bottom: 20px">
                            <label class="float-right mt-2">باقى العنوان:</label>
                            <input type="text" class="form-control" v-model="institution.restofadress"required>
                        </div>

                        <div class="col-lg-4" style="padding-bottom: 20px">
                            <label class="float-right mt-2">الرقم المميز لدى هيئة الذكاة</label>
                            <input type="number" class="form-control" v-model="institution.charity_num" required>
                        </div>
                        <div class="col-lg-4" style="padding-bottom: 20px">
                            <label class="float-right mt-2">رقم الضريبة المضافة</label>
                            <input type="number" class="form-control" v-model="institution.extra_tax_num" required >
                        </div>
                    </div>
            <!-- /.Create-Institution Form Content -->

            <!----- Choose revisers Form Content -->
                <div class="row" id="chooseRevisers">
                    <h3 class="box-header"> المراجع الفنى</h3>
                    <div class="col-lg-6" style="padding-bottom: 20px">

                        <select v-model="ChoosenReviserID" class="form-control"  required>
                            <option v-for="reviser in revisers" :value="reviser.id">
                                الكود :
                                {{reviser.id}}

                                الأسم :
                                {{reviser.name}}
                            </option>
                        </select>

                    </div>
                </div>
            <!----- /.Choose revisers Form Content -->
                <div class="col-md-12">
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-12 ">
                        <button  class="btn btn-block btn-success btn-lg" style="padding: 15px;width:230px" >  التالى</button>
                    </div>
                </div>
            </form>

        </div>

    </div>


</template>

<script>

    import {NewTradeRegisterForm} from './NewTradeRegisterForm.vue';

    export default {
        name: "NewCompanyForm.vue",
        data()
        {
            return{
                revisers : [],
                ChoosenReviserID : '',
              //////// Create-Institution DATA  //////
               institution : {
                   name : '',
                   company_number : '',
                   //العوان يتكون من التالي
                   city:'',
                   district:'',
                   restofadress:'',
                   //باقى بيانات الشركة
                   legal_entity:'',
                   angel_interests : '',
                   nature:'',
                   business_activity:'',
                   charity_num:'',
                   extra_tax_num:'',
               },

                created_institution : Object,
                NewCompanyNot_ADDED : true,
                ///////// Create TradeRegister Data /////////
                MainTradeRegister : {
                    number: '',
                    date: '',
                    production_place: '',
                    type: 'رئيسي',
                },
                BranchedTradeRegister : {
                    number: '',
                    date: '',
                    production_place: '',
                    type: 'فرعي',
                },
                AddedBranchedRegisters : [],
                NewMainRegisterNot_ADDED : true,
                AllBranchedRegistersNot_Added : true,
             /////  create Transaction Data ///////////
                transaction : {
                    FinancialYear : '',
                    start_financial_year : '',
                    end_financial_year : '',
                    start_financial_period : '',
                    end_financial_period : '',

                },

                NewTransactionNot_ADDED : true,
            }
        },
        created() {
            this.fetch(route('reviser.index'));
        },
        methods: {
            // get all the revisers in the system and put them in the array
            fetch(endpoint) {
                axios.get(endpoint)
                    .then(({data}) => {
                        data.revisers.forEach((reviser) => {
                            this.revisers.push(reviser);
                        });
                    })
            },
            createInstitution(){

                if(this.NewCompanyNot_ADDED)
                {
                    var formData = new FormData();

                    formData.append('address', this.getAddress);
                    formData.append('business_activity', this.institution.business_activity);
                    formData.append('name',this.institution.name);
                    formData.append('number',this.institution.company_number);
                    formData.append('legal_entity', this.institution.legal_entity);
                    formData.append('angel_interests', this.institution.angel_interests);
                    formData.append('nature', this.institution.nature);
                    formData.append('charity_num', this.institution.charity_num);
                    formData.append('extra_tax_num', this.institution.extra_tax_num);
                    axios.post(route('Institution.store'),
                        formData
                    ).then((res) => {
                        this.created_institution = res.data;
                        this.$parent.New_institution = res.data;

                        console.log('create institution is called ');
                        console.log('New Company added successfully Name : ' + this.created_institution.name);
                        this.NewCompanyNot_ADDED = false;

                        this.createTransaction();
                    }).catch((error) => {
                        console.log(error);
                    });
                }
                else if(!this.NewCompanyNot_ADDED){

                    this.createTransaction();
                }

            },
            createTransaction(){

                if(this.NewTransactionNot_ADDED){
                    var formData = new FormData();

                    formData.append('financial_year', this.transaction.FinancialYear);
                    formData.append('start_financial_year', this.transaction.start_financial_year);
                    formData.append('end_financial_year',this.transaction.end_financial_year);

                    formData.append('start_financial_period',this.transaction.start_financial_period);
                    formData.append('end_financial_period',this.transaction.end_financial_period);

                    console.log('create Transaction is called');
                    console.log('the choosen revised id is : ' + this.ChoosenReviserID);
                    console.log('the created institution is : ' + this.created_institution.name);

                    axios.post(route('Transactions.store', [this.created_institution.id, this.ChoosenReviserID] ),formData)
                        .then((res) => {
                            alert('Transaction Has Been Added Successfully');
                            console.log(res);
                            this.NewTransactionNot_ADDED = false;
                            this.$parent.New_Transaction = res.data;

                            this.createMainTradeRegister();
                        }).catch((error) => {
                        console.log(error);
                    });
                }

                else if(!this.NewTransactionNot_ADDED){
                    this.createMainTradeRegister();
                }

            },

            createMainTradeRegister(){
                if(this.NewMainRegisterNot_ADDED){
                    var formData = new FormData();

                    formData.append('number', this.MainTradeRegister.number);
                    formData.append('date', this.MainTradeRegister.date);
                    formData.append('production_place',this.MainTradeRegister.production_place);
                    formData.append('type',this.MainTradeRegister.type);

                    axios.post(route('TradeRegister.store',this.$parent.New_institution),formData)
                        .then((res) => {
                            console.log('Master TradeRegister Has Been Called');
                            console.log(res.data);
                            this.NewMainRegisterNot_ADDED = false;
                            this.createBranchedRegisters();
                        }).catch((error) => {
                        console.log(error);
                    });
                }
                else if(!this.NewMainRegisterNot_ADDED){
                    this.createBranchedRegisters();
                }

            },

            createBranchedRegisters(){


                this.AddedBranchedRegisters.forEach((register, index) => {

                    var formData = new FormData();

                    formData.append('number', register.number);
                    formData.append('date', register.date);
                    formData.append('production_place', register.production_place);
                    formData.append('type', register.type);

                    axios.post(route('TradeRegister.store',this.$parent.New_institution),formData)
                        .then((res) => {
                        alert('Branched TradeRegister Has Been Added Successfully');
                        this.removeRegisterFromList(index);
                    }).catch((error) => {
                        console.log(error);
                    });
                    if(this.AddedBranchedRegisters.length == 0){
                        this.AllBranchedRegistersNot_Added = false;

                        this.$parent.NewCompanySectionStage = 2;
                    }
                });

            },
            AddRegisterToList(){

              this.AddedBranchedRegisters.push({
                  number : this.BranchedTradeRegister.number,
                  date : this.BranchedTradeRegister.date,
                  production_place : this.BranchedTradeRegister.production_place,
                  type : this.BranchedTradeRegister.type,
              });
              this.ClearBranchedRegisterInput();
            },

            removeRegisterFromList(index){
                this.AddedBranchedRegisters.splice(index, 1);
            },

            ClearBranchedRegisterInput(){
                this.BranchedTradeRegister.number = '',
                    this.BranchedTradeRegister.date = '',
                    this.BranchedTradeRegister.production_place = ''
            },
        },

        computed : {
            getAddress(){
                return this.institution.restofadress + ',' + this.institution.city + ' , ' + this.institution.district;
            }
        }
    }
</script>

<style scoped>

</style>
