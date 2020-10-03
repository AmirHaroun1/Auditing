<template>
    <div class="box" style="margin-top: 20px">
        <div class="box-header">
            <h2 class="pb-3">بيانات مندوب الشركة</h2>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form @submit.prevent="createAgent()" class="form-group">
                <div class="row">
                    <div id="NewAgentForTheCompany">
                        <div class="col-md-12">
                            <h3 class="header" style="padding-bottom: 10px"> بيانات المندوب :</h3>
                        </div>
                        <div class="col-lg-6" style="padding-bottom: 20px">
                            <label class="float-right">رقم الهوية</label>
                            <input v-model="national_id" type="number" class="form-control pb-4"  style="padding-bottom: 20px"  placeholder="رقم الهوية">
                        </div>
                        <div class="col-lg-6" style="padding-bottom: 20px">
                            <div class="form-group ">
                                <label class="float-right pt-4">تاريخ الهوية</label>
                                <input v-model="national_id_date" type="date" class="form-control pb-5"  required>
                            </div>
                        </div>

                        <div class="col-lg-6" style="padding-bottom: 20px">
                            <div class="form-group ">
                                <label>الأسم بالكامل</label>
                                <input v-model="name" type="text" class="form-control"  placeholder="الأسم بالكامل" required>
                            </div>
                        </div>
                        <div class="col-lg-6" style="padding-bottom: 20px">
                            <div class="form-group ">
                                <label>تاريخ الميلاد</label>
                                <input v-model="birth_date" type="date" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-lg-6" style="padding-bottom: 20px">
                            <div class="form-group ">
                                <label>الإيميل</label>
                                <input v-model="email" type="email" class="form-control pb-5" autocomplete="email" required>
                            </div>
                        </div>

                        <div class="col-lg-6"style="padding-bottom: 20px">
                            <div class="form-group ">
                                <label>رقم الجوال</label>
                                <input v-model="phone" type="text" class="form-control pb-5" placeholder="رقم الجوال" required>
                            </div>
                        </div>
                        <div class="col-lg-6" style="padding-bottom: 20px">
                            <div class="form-group ">
                                <label class="float-right">الرقم السرى</label>
                                <input v-model="password" type="password" class="form-control pb-5"  placeholder="الرقم السرى" required>
                            </div>
                        </div>

                        <div class="col-md-6" style="padding-bottom: 20px">
                            <div class="form-group ">
                                <label class="float-right"> تأكيد الرقم السرى</label>
                                <input v-model="PasswordConfirmation" type="password" class="form-control"  placeholder=" تأكيد الرقم السرى" required>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row text-center center content-align-center">
                    <div class="col-md-12 ">
                        <button class="btn btn-block btn-success btn-lg" style="padding: 15px;width:230px" >  التالي</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
    export default {
        name: "NewAgentForm.vue",

        data(){
            return{
                //بيانات مندوب الشركة
                national_id : '',
                national_id_date:'',
                name: '',
                birth_date: '',
                email: '',
                phone: '',
                password: '',
                PasswordConfirmation: '',
            }
        },
        methods :{
            createAgent() {
                var formData = new FormData();

                formData.append('national_id', this.national_id);
                formData.append('national_id_date', this.national_id_date);
                formData.append('name', this.name);
                formData.append('birth_date', this.birth_date);
                formData.append('email', this.email);
                formData.append('phone', this.phone);
                formData.append('password', this.password);
                formData.append('password_confirmation', this.passwordConfirmation);
                formData.append('role', 'سكرتير');

                axios.post(route('agent.store',this.$parent.New_institution),
                    formData
                ).then((res) => {
                    this.$parent.New_agent = res.data;
                    alert('Agent added successfully');
                    this.$parent.NewCompanySectionStage = 3 ;

                }).catch((error) => {
                    console.log(error);
                });
            }
        },
    }
</script>

<style scoped>

</style>
