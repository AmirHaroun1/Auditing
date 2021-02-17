<template>
    <div class="container box mt-20">
        <div v-if="LoadingSpinner" class="overlay">
            <i class="fa fa-refresh fa-spin">
            </i>
        </div>
        <div class="row">
            <div class="box-header">
                <div class="col-md-6">

                    <h2>الإيضاحات</h2>
                </div>
                <div class="col-md-6">

                    <button class="p-10 border-none fa fa-print mt-20 bg-green text-white" @click="DownloadExcel()"> تصدير إكسل </button>
                </div>
                <div class="col-md-12">

                    <hr>
                </div>
            </div>
            <div class="box-body" id="printHeading">

                <div v-if="Accounts.length" v-for="FirstLVLAccount in Accounts" :key="FirstLVLAccount.id">

                    <!-- check if the first level account has clearance number -->
                        <div :id="FirstLVLAccount.id+'print'" v-if="FirstLVLAccount.ClearanceNumber" >
                            <div @click="FirstLVLAccount.MonetaryItems ? '':GetAccountValues(FirstLVLAccount)" data-toggle="collapse" :data-target="'#'+'collapse'+FirstLVLAccount.id" aria-expanded="true" :aria-controls="FirstLVLAccount.id" class="col-md-12  mt-20 cursor-pointer mb-20 content-between" style="border: 2px #00a65a dashed;">

                                <h3 class="cursor-pointer">
                                    إيضاح :
                                    {{FirstLVLAccount.ClearanceNumber}}
                                    ,
                                    {{FirstLVLAccount.name}}
                                </h3>

                            </div>
                            <!----- collapsed tap content ------->
                            <div :id="'collapse'+FirstLVLAccount.id" class="collapse fade">
                                <div  >
                                    <h3 class="text-center"><i @click.prevent="printHeading(FirstLVLAccount.id)" class=" fa fa-print cursor-pointer" style="margin-left:15px;" ></i></h3>
                                </div>
                                <!------ Policy -------->
                                    <div  class="row mt-10 " style="direction:rtl;margin-top:20px">
                                        <div class="col-md-2">
                                            <h3>
                                                السياسة :
                                            </h3>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea v-if="!PrintingMood" v-model="FirstLVLAccount.policy" class="form-control">
                                            </textarea>
                                            <h4 v-else>{{FirstLVLAccount.policy}}</h4>
                                        </div>
                                    </div>
                                    <hr>
                                <!------ ./Policy -------->

                                <!------ considerations -------->
                                    <div  class="row mt-20 " style="direction:rtl;margin-top:20px">
                                        <div class="col-md-2">
                                            <h3>
                                                لفت انتباه :
                                            </h3>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea v-if="!PrintingMood" v-model="FirstLVLAccount.considerations" class="form-control">
                                            </textarea>
                                            <h4 v-else>{{FirstLVLAccount.considerations}}</h4>
                                        </div>
                                    </div>
                                    <hr>
                                <!------ ./considerations -------->

                                <!------- Table ------------->
                                <div class=" mt-20 " style="direction:rtl"  v-if="FirstLVLAccount.MonetaryItems">
                                    <h3 class="mt-20">
                                        يتكون بند {{FirstLVLAccount.name}}
                                        من :
                                    </h3>
                                    <table class="mt-20 table table-bordered" >
                                        <thead>
                                        <tr>
                                            <th rowspan="2" colspan="1" >
                                                .
                                            </th>
                                            <th  rowspan="2" colspan="1">
                                                الأسم
                                            </th>
                                            <th class="text-center"  rowspan="1" colspan="2">
                                                حركة
                                            </th>
                                            <th class="text-center" rowspan="1" colspan="2" >
                                                تعديل
                                            </th>
                                            <th class="text-center" rowspan="1" colspan="1" >
                                                الرصيد النهائي
                                            </th>


                                        </tr>
                                        <tr>
                                            <th >مدين</th>
                                            <th >دائن</th>

                                            <th>مدين</th>
                                            <th >دائن</th>

                                            <th class="text-center">{{Transaction.end_financial_year}}</th>
                                            <th >
                                                5%
                                            </th>
                                            <th >
                                                10%
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                            <tr v-for="(item,index) in FirstLVLAccount.MonetaryItems" :key="item.id">

                                                <td>
                                                    <h4>{{FirstLVLAccount.ClearanceNumber + '.00'}}{{index+1}}</h4>
                                                </td>
                                                <td>
                                                    <h4>{{item.name}}</h4>
                                                </td>
                                                <td>
                                                    <h4>{{item.current_year_debtor}}</h4>
                                                </td>
                                                <td>
                                                    <h4>{{item.current_year_creditor}}</h4>
                                                </td>
                                                <td>
                                                    <h4 class="cursor-pointer" @click="$set(item,'EditCurrentYearDebtor', true)" v-text="item.edited_current_year_debtor != '' ? item.edited_current_year_debtor : 0"></h4>
                                                    <input v-model="item.edited_current_year_debtor" class="form-control" type="text" v-if="item.EditCurrentYearDebtor" v-on:keyup.enter="EditTransactionAccount(item, 'DebitEdit',FirstLVLAccount)" >
                                                </td>
                                                <td>
                                                    <h4 class="cursor-pointer" @click="$set(item,'EditCurrentYearCreditor', true)"v-text="item.edited_current_year_creditor != '' ? item.edited_current_year_creditor : 0"></h4>
                                                    <input v-model="item.edited_current_year_creditor" class="form-control" type="text" v-if="item.EditCurrentYearCreditor" v-on:keyup.enter="EditTransactionAccount(item, 'CreditEdit',FirstLVLAccount)" >
                                                </td>

                                                <td class="text-center">
                                                     <h4 >{{(item.edited_current_year_creditor - item.edited_current_year_debtor) + (item.current_year_creditor-item.current_year_debtor ) }}</h4>

                                                </td>
                                                <td style="vertical-align:middle;text-align:center" :rowspan="FirstLVLAccount.MonetaryItems.length" v-if="index == 0">
                                                    <h4 v-model="FirstLVLAccount.FivePercent"> {{FirstLVLAccount.FinalCredit * 0.05}}</h4>
                                                </td>
                                                <td style="vertical-align:middle;text-align:center" :rowspan="FirstLVLAccount.MonetaryItems.length" v-if="index == 0">
                                                    <h4 v-model="FirstLVLAccount.TenPercent">{{FirstLVLAccount.FinalCredit * 0.10}}</h4>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td><h4>الرصيد آخر السنة</h4></td>
                                                <td style="visibility: hidden"></td>
                                                <td style="visibility: hidden"></td>
                                                <td style="visibility: hidden"></td>
                                                <td style="visibility: hidden"></td>
                                                <td style="visibility: hidden"></td>
                                                <td >
                                                   <h4 class="text-center"> {{FirstLVLAccount.FinalCredit}} </h4>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!------- ./Table ------------->

                                <!------ Study -------->
                                <hr>
                                <div  class="row mt-10 " style="direction:rtl;margin-top:20px">
                                    <div class="col-md-2">
                                        <h3>
                                            الدراسة :
                                        </h3>
                                    </div>
                                    <div class="col-md-8">
                                            <textarea v-if="!PrintingMood" v-model="FirstLVLAccount.study" class="form-control">
                                            </textarea>
                                        <h4 v-else>{{FirstLVLAccount.study}}</h4>
                                    </div>
                                </div>
                                <hr>
                                <!------ ./Study -------->

                            </div>
                            <!----- ./collapsed tap content ------->
                        </div>
                    <!-- ./ check if the first level account has clearance number -->

                    <!-- if FirstLVLAccount doesn't have clearance number  -->
                        <!-- check if the second level account has clearance number -->
                        <div v-if="FirstLVLAccount.second_level_accounts.length && !FirstLVLAccount.ClearanceNumber" v-for="SecondLVLAccount in FirstLVLAccount.second_level_accounts">

                                <!----- if SecondLVLAccount level has clearance number --->
                                <div :id="SecondLVLAccount.id+'print'"  v-if="SecondLVLAccount.ClearanceNumber">
                                    <div @click="SecondLVLAccount.MonetaryItems ? '':GetAccountValues(SecondLVLAccount)" data-toggle="collapse" :data-target="'#'+'collapse'+SecondLVLAccount.id" aria-expanded="true" :aria-controls="SecondLVLAccount.id" class="col-md-12  mt-20 cursor-pointer mb-20 content-between" style="border: 2px #00a65a dashed;">
                                        <h3 class="cursor-pointer">
                                            إيضاح :
                                            {{SecondLVLAccount.ClearanceNumber}}
                                            ,
                                            {{SecondLVLAccount.name}}
                                        </h3>
                                    </div>
                                    <!----- collapsed tap content ------->
                                    <div :id="'collapse'+SecondLVLAccount.id" class="collapse fade">
                                        <div>
                                            <h3 class="text-center"><i @click.prevent="printHeading(SecondLVLAccount.id)" class=" fa fa-print cursor-pointer" style="margin-left:15px;" ></i></h3>
                                        </div>
                                        <!------ Policy -------->
                                        <div  class="row mt-10 " style="direction:rtl;margin-top:20px">
                                            <div class="col-md-2">
                                                <h3>
                                                    السياسة :
                                                </h3>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea v-if="!PrintingMood" v-model="SecondLVLAccount.policy" class="form-control">
                                                </textarea>
                                                <h4 v-else>{{SecondLVLAccount.policy}}</h4>
                                            </div>
                                        </div>
                                        <hr>
                                        <!------ ./Policy -------->

                                        <!------ considerations -------->
                                        <div  class="row mt-20 " style="direction:rtl;margin-top:20px">
                                            <div class="col-md-2">
                                                <h3>
                                                    لفت انتباه :
                                                </h3>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea v-if="!PrintingMood" v-model="SecondLVLAccount.considerations" class="form-control">
                                                </textarea>
                                                <h4 v-else>{{SecondLVLAccount.considerations}}</h4>
                                            </div>
                                        </div>
                                        <hr>
                                        <!------ ./considerations -------->

                                        <!------- Table ------------->
                                        <div class=" mt-20 " style="direction:rtl"  v-if="SecondLVLAccount.MonetaryItems">
                                            <h3 class="mt-20">
                                                يتكون بند {{SecondLVLAccount.name}}
                                                من :
                                            </h3>
                                            <table class="mt-20 table table-bordered" >
                                                <thead>
                                                <tr>
                                                    <th rowspan="2" colspan="1" >
                                                        .
                                                    </th>
                                                    <th  rowspan="2" colspan="1">
                                                        الأسم
                                                    </th>
                                                    <th class="text-center"  rowspan="1" colspan="2">
                                                        حركة
                                                    </th>
                                                    <th class="text-center" rowspan="1" colspan="2" >
                                                        تعديل
                                                    </th>
                                                    <th class="text-center" rowspan="1" colspan="1" >
                                                        الرصيد النهائي
                                                    </th>


                                                </tr>
                                                <tr>
                                                    <th >مدين</th>
                                                    <th >دائن</th>

                                                    <th>مدين</th>
                                                    <th >دائن</th>

                                                    <th class="text-center">{{Transaction.end_financial_year}}</th>
                                                    <th >
                                                        5%
                                                    </th>
                                                    <th >
                                                        10%
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody >
                                                <tr v-for="(item,index) in SecondLVLAccount.MonetaryItems" :key="item.id">

                                                    <td>
                                                        <h4>{{SecondLVLAccount.ClearanceNumber + '.0'}}{{index+1}}</h4>
                                                    </td>
                                                    <td>
                                                        <h4>{{item.name}}</h4>
                                                    </td>
                                                    <td>
                                                        <h4>{{item.current_year_debtor}}</h4>
                                                    </td>
                                                    <td>
                                                        <h4>{{item.current_year_creditor}}</h4>
                                                    </td>
                                                    <td>
                                                        <h4 class="cursor-pointer" @click="$set(item,'EditCurrentYearDebtor', true)" v-text="item.edited_current_year_debtor != '' ? item.edited_current_year_debtor : 0"></h4>
                                                        <input v-model="item.edited_current_year_debtor" class="form-control" type="text" v-if="item.EditCurrentYearDebtor" v-on:keyup.enter="EditTransactionAccount(item, 'DebitEdit',SecondLVLAccount)" >
                                                    </td>
                                                    <td>
                                                        <h4 class="cursor-pointer" @click="$set(item,'EditCurrentYearCreditor', true)"v-text="item.edited_current_year_creditor != '' ? item.edited_current_year_creditor : 0"></h4>
                                                        <input v-model="item.edited_current_year_creditor" class="form-control" type="text" v-if="item.EditCurrentYearCreditor" v-on:keyup.enter="EditTransactionAccount(item, 'CreditEdit',SecondLVLAccount)" >
                                                    </td>

                                                    <td class="text-center">
                                                        <h4 >{{(item.edited_current_year_creditor - item.edited_current_year_debtor) + (item.current_year_creditor-item.current_year_debtor ) }}</h4>

                                                    </td>
                                                    <td style="vertical-align:middle;text-align:center" :rowspan="SecondLVLAccount.MonetaryItems.length" v-if="index == 0">
                                                        <h4 v-model="SecondLVLAccount.FivePercent"> {{SecondLVLAccount.FinalCredit * 0.05}}</h4>
                                                    </td>
                                                    <td style="vertical-align:middle;text-align:center" :rowspan="SecondLVLAccount.MonetaryItems.length" v-if="index == 0">
                                                        <h4 v-model="SecondLVLAccount.TenPercent">{{SecondLVLAccount.FinalCredit * 0.10}}</h4>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><h4>الرصيد آخر السنة</h4></td>
                                                    <td style="visibility: hidden"></td>
                                                    <td style="visibility: hidden"></td>
                                                    <td style="visibility: hidden"></td>
                                                    <td style="visibility: hidden"></td>
                                                    <td style="visibility: hidden"></td>
                                                    <td >
                                                        <h4 class="text-center"> {{SecondLVLAccount.FinalCredit}} </h4>
                                                    </td>

                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!------- ./Table ------------->

                                        <!------ Study -------->
                                        <hr>
                                        <div  class="row mt-10 " style="direction:rtl;margin-top:20px">
                                            <div class="col-md-2">
                                                <h3>
                                                    الدراسة :
                                                </h3>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea v-if="!PrintingMood" v-model="SecondLVLAccount.study" class="form-control">
                                                </textarea>
                                                <h4 v-else>{{SecondLVLAccount.study}}</h4>
                                            </div>
                                        </div>
                                        <hr>
                                        <!------ ./Study -------->

                                    </div>
                                    <!----- ./collapsed tap content ------->
                                </div>
                                <!----- if ./SecondLVLAccount level has clearance number --->

                            <!-- if SecondLVLAccount doesn't have clearance number  -->


                                <!-- check if the third level account has clearance number -->
                                <div v-else-if="SecondLVLAccount.third_level_accounts.length" v-for="ThirdLVLAccount in SecondLVLAccount.third_level_accounts">

                                    <!----- if ThirdLVLAccount level doesn't have Fourth level Accounts --->
                                        <!----- if ThirdLVLAccount level has clearance number --->
                                        <div  :id="ThirdLVLAccount.id+'print'"  v-if="ThirdLVLAccount.ClearanceNumber && ThirdLVLAccount.fourth_level_accounts.length == 0" >

                                            <div @click="ThirdLVLAccount.MonetaryItems ? '':GetAccountValues(ThirdLVLAccount)" data-toggle="collapse" :data-target="'#'+'collapse'+ThirdLVLAccount.id" aria-expanded="true" :aria-controls="ThirdLVLAccount.id" class="col-md-12  mt-20 cursor-pointer mb-20 content-between" style="border: 2px #00a65a dashed;">
                                                <h3 class="cursor-pointer">
                                                    إيضاح :
                                                    {{ThirdLVLAccount.ClearanceNumber}}
                                                    ,
                                                    {{ThirdLVLAccount.name}}

                                                </h3>
                                            </div>
                                            <!----- collapsed tap content ------->
                                            <div :id="'collapse'+ThirdLVLAccount.id" class="collapse fade">
                                                <div>
                                                    <h3 class="text-center"><i @click.prevent="printHeading(ThirdLVLAccount.id)" class=" fa fa-print cursor-pointer" style="margin-left:15px;" ></i></h3>
                                                </div>
                                                <!------ Policy -------->
                                                <div  class="row mt-10 " style="direction:rtl;margin-top:20px">
                                                    <div class="col-md-2">
                                                        <h3>
                                                            السياسة :
                                                        </h3>
                                                    </div>
                                                    <div class="col-md-8">
                                                <textarea v-if="!PrintingMood" v-model="ThirdLVLAccount.policy" class="form-control">
                                                </textarea>
                                                        <h4 v-else>{{ThirdLVLAccount.policy}}</h4>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!------ ./Policy -------->

                                                <!------ considerations -------->
                                                <div  class="row mt-20 " style="direction:rtl;margin-top:20px">
                                                    <div class="col-md-2">
                                                        <h3>
                                                            لفت انتباه :
                                                        </h3>
                                                    </div>
                                                    <div class="col-md-8">
                                                <textarea v-if="!PrintingMood" v-model="ThirdLVLAccount.considerations" class="form-control">
                                                </textarea>
                                                        <h4 v-else>{{ThirdLVLAccount.considerations}}</h4>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!------ ./considerations -------->

                                                <!------- Table ------------->
                                                <div class=" mt-20 " style="direction:rtl"  v-if="ThirdLVLAccount.MonetaryItems">
                                                    <h3 class="mt-20">
                                                        يتكون بند {{ThirdLVLAccount.name}}
                                                        من :
                                                    </h3>
                                                    <table class="mt-20 table table-bordered" >
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2" colspan="1" >
                                                                .
                                                            </th>
                                                            <th  rowspan="2" colspan="1">
                                                                الأسم
                                                            </th>
                                                            <th class="text-center"  rowspan="1" colspan="2">
                                                                حركة
                                                            </th>
                                                            <th class="text-center" rowspan="1" colspan="2" >
                                                                تعديل
                                                            </th>
                                                            <th class="text-center" rowspan="1" colspan="1" >
                                                                الرصيد النهائي
                                                            </th>


                                                        </tr>
                                                        <tr>
                                                            <th >مدين</th>
                                                            <th >دائن</th>

                                                            <th>مدين</th>
                                                            <th >دائن</th>

                                                            <th class="text-center">{{Transaction.end_financial_year}}</th>
                                                            <th >
                                                                5%
                                                            </th>
                                                            <th >
                                                                10%
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody >
                                                        <tr v-for="(item,index) in ThirdLVLAccount.MonetaryItems" :key="item.id">

                                                            <td>
                                                                <h4>{{ThirdLVLAccount.ClearanceNumber + '.0'}}{{index+1}}</h4>
                                                            </td>
                                                            <td>
                                                                <h4>{{item.name}}</h4>
                                                            </td>
                                                            <td>
                                                                <h4>{{item.current_year_debtor}}</h4>
                                                            </td>
                                                            <td>
                                                                <h4>{{item.current_year_creditor}}</h4>
                                                            </td>
                                                            <td>
                                                                <h4 class="cursor-pointer" @click="$set(item,'EditCurrentYearDebtor', true)" v-text="item.edited_current_year_debtor != '' ? item.edited_current_year_debtor : 0"></h4>
                                                                <input v-model="item.edited_current_year_debtor" class="form-control" type="text" v-if="item.EditCurrentYearDebtor" v-on:keyup.enter="EditTransactionAccount(item, 'DebitEdit',ThirdLVLAccount)" >
                                                            </td>
                                                            <td>
                                                                <h4 class="cursor-pointer" @click="$set(item,'EditCurrentYearCreditor', true)"v-text="item.edited_current_year_creditor != '' ? item.edited_current_year_creditor : 0"></h4>
                                                                <input v-model="item.edited_current_year_creditor" class="form-control" type="text" v-if="item.EditCurrentYearCreditor" v-on:keyup.enter="EditTransactionAccount(item, 'CreditEdit',ThirdLVLAccount)" >
                                                            </td>

                                                            <td class="text-center">
                                                                <h4 >{{(item.edited_current_year_creditor - item.edited_current_year_debtor) + (item.current_year_creditor-item.current_year_debtor ) }}</h4>

                                                            </td>
                                                            <td style="vertical-align:middle;text-align:center" :rowspan="ThirdLVLAccount.MonetaryItems.length" v-if="index == 0">
                                                                <h4 v-model="ThirdLVLAccountFivePercent"> {{ThirdLVLAccount.FinalCredit * 0.05}}</h4>
                                                            </td>
                                                            <td style="vertical-align:middle;text-align:center" :rowspan="ThirdLVLAccount.MonetaryItems.length" v-if="index == 0">
                                                                <h4 v-model="ThirdLVLAccountTenPercent">{{ThirdLVLAccount.FinalCredit * 0.10}}</h4>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td><h4>الرصيد آخر السنة</h4></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td >
                                                                <h4 class="text-center"> {{ThirdLVLAccount.FinalCredit}} </h4>
                                                            </td>

                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!------- ./Table ------------->

                                                <!------ Study -------->
                                                <hr>
                                                <div  class="row mt-10 " style="direction:rtl;margin-top:20px">
                                                    <div class="col-md-2">
                                                        <h3>
                                                            الدراسة :
                                                        </h3>
                                                    </div>
                                                    <div class="col-md-8">
                                                <textarea v-if="!PrintingMood" v-model="ThirdLVLAccount.study" class="form-control">
                                                </textarea>
                                                        <h4 v-else>{{ThirdLVLAccount.study}}</h4>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!------ ./Study -------->

                                            </div>
                                            <!----- ./collapsed tap content ------->

                                        </div>
                                        <!----- ./if ThirdLVLAccount level has clearance number --->
                                    <!----- ./if ThirdLVLAccount level doesn't have Fourth level Accounts --->

                                    <!----- if ThirdLVLAccount level  have Fourth level Accounts --->
                                        <!----- if ThirdLVLAccount level has clearance number --->
                                        <div  :id="ThirdLVLAccount.id+'print'"  v-else-if="ThirdLVLAccount.ClearanceNumber && ThirdLVLAccount.fourth_level_accounts.length" >

                                            <div @click="GetFourthLevelAccountsValuesOfThirdLevelAccount(ThirdLVLAccount)" data-toggle="collapse" :data-target="'#'+'collapse'+ThirdLVLAccount.id" aria-expanded="true" :aria-controls="ThirdLVLAccount.id" class="col-md-12  mt-20 cursor-pointer mb-20 content-between" style="border: 2px #00a65a dashed;">
                                                <h3 class="cursor-pointer">
                                                    إيضاح :
                                                    {{ThirdLVLAccount.ClearanceNumber}}
                                                    ,
                                                    {{ThirdLVLAccount.name}}

                                                </h3>
                                            </div>
                                            <!--------- div contains all fourth level accounts ----------->
                                            <div :id="'collapse'+ThirdLVLAccount.id" class="collapse fade">
                                                <div>
                                                    <h3 class="text-center"><i @click.prevent="printHeading(ThirdLVLAccount.id)" class=" fa fa-print cursor-pointer" style="margin-left:15px;" ></i></h3>
                                                </div>
                                                <!------ Policy -------->
                                                <div  class="row mt-10 " style="direction:rtl;margin-top:20px">
                                                    <div class="col-md-2">
                                                        <h3>
                                                            السياسة :
                                                        </h3>
                                                    </div>
                                                    <div class="col-md-8">
                                                <textarea v-if="!PrintingMood" v-model="ThirdLVLAccount.policy" class="form-control">
                                                </textarea>
                                                        <h4 v-else>{{ThirdLVLAccount.policy}}</h4>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!------ ./Policy -------->

                                                <!------ considerations -------->
                                                <div  class="row mt-20 " style="direction:rtl;margin-top:20px">
                                                    <div class="col-md-2">
                                                        <h3>
                                                            لفت انتباه :
                                                        </h3>
                                                    </div>
                                                    <div class="col-md-8">
                                                <textarea v-if="!PrintingMood" v-model="ThirdLVLAccount.considerations" class="form-control">
                                                </textarea>
                                                        <h4 v-else>{{ThirdLVLAccount.considerations}}</h4>
                                                    </div>
                                                </div>
                                                <hr>
                                                <!------ ./considerations -------->
                                                <!------- Table ------------->
                                                <div class=" mt-20 " style="direction:rtl">
                                                    <h3 class="mt-20">
                                                        يتكون بند {{ThirdLVLAccount.name}}
                                                        من :
                                                    </h3>
                                                    <table v-for="(FourthLVLAccount,FourthLVLindex) in ThirdLVLAccount.fourth_level_accounts" class="mt-20 table table-bordered" >
                                                        <thead v-if="FourthLVLAccount.MonetaryItems && FourthLVLAccount.MonetaryItems.length" >
                                                        <tr>
                                                            <th colspan="7">
                                                                <h4>
                                                                    {{ThirdLVLAccount.ClearanceNumber + '.0'}}{{FourthLVLindex+1}}
                                                                    {{FourthLVLAccount.name}}

                                                                </h4>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th rowspan="2" colspan="1" >
                                                                .
                                                            </th>
                                                            <th  rowspan="2" colspan="1">
                                                                الأسم
                                                            </th>
                                                            <th class="text-center"  rowspan="1" colspan="2">
                                                                حركة
                                                            </th>
                                                            <th class="text-center" rowspan="1" colspan="2" >
                                                                تعديل
                                                            </th>
                                                            <th v-if="FourthLVLindex == ThirdLVLAccount.fourth_level_accounts.length-1"  class="text-center" rowspan="1" colspan="1" >
                                                                الرصيد النهائي
                                                            </th>


                                                        </tr>
                                                        <tr >
                                                            <th >مدين</th>
                                                            <th >دائن</th>

                                                            <th>مدين</th>
                                                            <th >دائن</th>

                                                            <th class="text-center">{{Transaction.end_financial_year}}</th>
                                                            <th>
                                                                5%
                                                            </th>
                                                            <th >
                                                                10%
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody >
                                                        <tr v-for="(item,index) in FourthLVLAccount.MonetaryItems" :key="item.id">

                                                            <td>
                                                                <h4>

                                                                    {{ThirdLVLAccount.ClearanceNumber + '.0'}}{{FourthLVLindex+1}}{{'0'+(index+1)}}
                                                                </h4>
                                                            </td>
                                                            <td>
                                                                <h4>{{item.name}}</h4>
                                                            </td>
                                                            <td>
                                                                <h4>{{item.current_year_debtor}}</h4>
                                                            </td>
                                                            <td>
                                                                <h4>{{item.current_year_creditor}}</h4>
                                                            </td>
                                                            <td>
                                                                <h4 class="cursor-pointer" @click="$set(item,'EditCurrentYearDebtor', true)" v-text="item.edited_current_year_debtor != '' ? item.edited_current_year_debtor : 0"></h4>
                                                                <input v-model="item.edited_current_year_debtor" class="form-control" type="text" v-if="item.EditCurrentYearDebtor" v-on:keyup.enter="EditTransactionAccount(item, 'DebitEdit',FourthLVLAccount)" >
                                                            </td>
                                                            <td>
                                                                <h4 class="cursor-pointer" @click="$set(item,'EditCurrentYearCreditor', true)"v-text="item.edited_current_year_creditor != '' ? item.edited_current_year_creditor : 0"></h4>
                                                                <input v-model="item.edited_current_year_creditor" class="form-control" type="text" v-if="item.EditCurrentYearCreditor" v-on:keyup.enter="EditTransactionAccount(item, 'CreditEdit',FourthLVLAccount)" >
                                                            </td>

                                                            <td class="text-center">
                                                                <h4 >{{(item.edited_current_year_creditor - item.edited_current_year_debtor) + (item.current_year_creditor-item.current_year_debtor ) }}</h4>

                                                            </td>
                                                            <td style="vertical-align:middle;text-align:center" :rowspan="FourthLVLAccount.MonetaryItems.length" v-if="index == 0">
                                                                <h4 > {{FourthLVLAccount.FinalCredit * 0.05}}</h4>
                                                            </td>
                                                            <td style="vertical-align:middle;text-align:center" :rowspan="FourthLVLAccount.MonetaryItems.length" v-if="index == 0">
                                                                <h4>{{FourthLVLAccount.FinalCredit * 0.10}}</h4>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td><h4>الرصيد آخر السنة</h4></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td style="visibility: hidden"></td>
                                                            <td >
                                                                <h4 class="text-center"> {{FourthLVLAccount.FinalCredit}} </h4>
                                                            </td>

                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!------- ./Table ------------->


                                            </div>
                                            <!--------- ./div contains all fourth level accounts ----------->

                                        </div>
                                        <!----- ./if ThirdLVLAccount level has clearance number --->
                                    <!----- ./if ThirdLVLAccount level have Fourth level Accounts --->


                                </div>
                              <!-- check if the third level account has clearance number -->



                            <!-- if ./SecondLVLAccount doesn't have clearance number  -->

                        </div>
                        <!-- ./ check if the second level account has clearance number -->
                    <!-- ./if FirstLVLAccount doesn't have clearance number  -->

                </div>

            </div>


        </div>
    </div>

</template>

<script>
    import ClickOutside from 'vue-click-outside'

    export default {
        name: "TransactionClearances",
        directives: {
            ClickOutside
        },
        props:{
            'Transaction':'',
        },
        data(){
            return{
                LoadingSpinner:'',

                Accounts:[],


                ExcelAccounts:[],
                ClearanceCounter:0,
                PrintingMood : false,

                ArabicMonths:[{'Number':1,'Name':'يناير'},{'Number':2,'Name':'فبراير'},{'Number':3,'Name':'مارس'},{'Number':4,'Name':'أبريل'},{'Number':5,'Name':'مايو'},{'Number':6,'Name':'يونيو'},{'Number':7,'Name':'يوليو'},{'Number':8,'Name':'أغسطس'},{'Number':9,'Name':'سبتمبر'},{'Number':10,'Name':'أكتوبر'},{'Number':11,'Name':'نوفمبر'},{'Number':12,'Name':'ديسمبر'}]
            }
        },

        created() {
            this.GetSumOfAccountsOfTransaction(route('accounts.transactions.sum',this.Transaction));
        },
        methods:{

            GetSumOfAccountsOfTransaction(endpoint){
                this.LoadingSpinner = true;
                this.GetEndDateOfTransactionInArabic();
                axios.get(endpoint)
                    .then(({data})=>{

                        this.Accounts.push(...data.NestedAccountsWithSum);
                        this.LoadingSpinner = false;
                        this.SetClearanceNumber();

                    }).catch((error)=>{
                    console.log(error);
                    this.$toast.error('.','حدث خطأ برجاء اعادة المحاولة',{timout:300});
                    this.LoadingSpinner = false;

                });


            },

            SetClearanceNumber(){
                this.LoadingSpinner = true;
                let ClearanceIsAddedd = false;
                this.Accounts.forEach(FirstLVLAccount =>{

                    if(FirstLVLAccount.CurrentYearSum != 0 &&FirstLVLAccount.CurrentYearSum != null && !FirstLVLAccount.second_level_accounts.length){
                        this.ClearanceCounter++;
                        this.$set(FirstLVLAccount,'ClearanceNumber',this.ClearanceCounter);

                        // filling Excel Account

                    }
                    else{
                        FirstLVLAccount.second_level_accounts.forEach(SecondLVLAccount =>{

                            SecondLVLAccount.third_level_accounts.forEach(ThirdLVLAccount =>{

                                ThirdLVLAccount.fourth_level_accounts.forEach(FourthLVLAccount =>{

                                    if(FourthLVLAccount.CurrentYearSum != 0 && FourthLVLAccount.CurrentYearSum != null){

                                        // if the fourth level Account Sum is not 0 or null and the third level didn't have Clearance Number increment clearance number and assign it to third LVL
                                        if(ClearanceIsAddedd !== true){
                                            this.ClearanceCounter++;
                                            this.$set(ThirdLVLAccount,'ClearanceNumber',this.ClearanceCounter);
                                            ClearanceIsAddedd = true;
                                        }

                                        // Add the sum of each fourth level account to the sum of parent account
                                        ThirdLVLAccount.CurrentYearSum += FourthLVLAccount.CurrentYearSum;
                                        ThirdLVLAccount.FirstPastYearSum += FourthLVLAccount.FirstPastYearSum;
                                        ThirdLVLAccount.SecondPastYearSum += FourthLVLAccount.SecondPastYearSum;
                                        ThirdLVLAccount.ThirdPastYearSum += FourthLVLAccount.ThirdPastYearSum;
                                        ThirdLVLAccount.FourthPastYearSum += FourthLVLAccount.FourthPastYearSum;

                                        // filling Excel Account
                                    }

                                })

                                ClearanceIsAddedd = false;
                                if(ThirdLVLAccount.CurrentYearSum != 0 && ThirdLVLAccount.CurrentYearSum != null) {

                                    if(!ThirdLVLAccount.fourth_level_accounts.length){

                                        this.ClearanceCounter++;
                                        this.$set(ThirdLVLAccount,'ClearanceNumber',this.ClearanceCounter);

                                    }
                                    // Add the sum of each third level account to the sum of parent account
                                    SecondLVLAccount.CurrentYearSum += ThirdLVLAccount.CurrentYearSum;
                                    SecondLVLAccount.FirstPastYearSum += ThirdLVLAccount.FirstPastYearSum;
                                    SecondLVLAccount.SecondPastYearSum += ThirdLVLAccount.SecondPastYearSum;
                                    SecondLVLAccount.ThirdPastYearSum += ThirdLVLAccount.ThirdPastYearSum;
                                    SecondLVLAccount.FourthPastYearSum += ThirdLVLAccount.FourthPastYearSum;
                                }

                            });

                            if(SecondLVLAccount.CurrentYearSum != 0 && SecondLVLAccount.CurrentYearSum != null) {
                                // if the second level doesn't have third accounts then it will take a ClearanceNumber
                                if(!SecondLVLAccount.third_level_accounts.length){

                                    this.ClearanceCounter++;
                                    this.$set(SecondLVLAccount,'ClearanceNumber',this.ClearanceCounter);

                                }
                                // Add the sum of each Second level account to the sum of parent account
                                FirstLVLAccount.CurrentYearSum += SecondLVLAccount.CurrentYearSum;
                                FirstLVLAccount.FirstPastYearSum += SecondLVLAccount.FirstPastYearSum;
                                FirstLVLAccount.SecondPastYearSum += SecondLVLAccount.SecondPastYearSum;
                                FirstLVLAccount.ThirdPastYearSum += SecondLVLAccount.ThirdPastYearSum;
                                FirstLVLAccount.FourthPastYearSum += SecondLVLAccount.FourthPastYearSum;
                            }
                        })
                    }
                })
                this.LoadingSpinner = false;
            },
            GetAccountValues(Account){
                this.LoadingSpinner = true;
                axios.get(route('accounts.transactions.index',[Account.id,this.Transaction.id,Account.level]))
                    .then(({data})=>{

                        this.$set(Account,'MonetaryItems',[]);
                        this.$set(Account,'FinalCredit',0);



                        data.transactions.forEach(transaction => {

                            Account.MonetaryItems.push(transaction.pivot);

                            Account.FinalCredit += (transaction.pivot.edited_current_year_creditor-transaction.pivot.edited_current_year_debtor)+(transaction.pivot.current_year_creditor - transaction.pivot.current_year_debtor);

                        });
                        this.LoadingSpinner = false;

                    }).catch((error)=>{
                    this.$toast.error('.','حدث خطأ برجاء اعادة المحاولة',{timout:300})
                });
            },
            GetFourthLevelAccountsValuesOfThirdLevelAccount(ThirdLVLAccount){
                ThirdLVLAccount.fourth_level_accounts.forEach(FourthLVLAccount=>{
                    this.GetAccountValues(FourthLVLAccount);
                })
            },
            GetEndDateOfTransactionInArabic(){

                var splitedDate = this.Transaction.end_financial_year.split('-');

                splitedDate[1] = this.ArabicMonths.find(Month => {
                    if (Month.Number == splitedDate[1]){
                         return Month;
                    }
                });
                if(splitedDate[1]){

                    this.Transaction.end_financial_year = splitedDate[2]+' / '+splitedDate[1].Name+' / '+splitedDate[0];
                }


            },
            printHeading(accountID){
                this.LoadingSpinner = true;
                this.PrintingMood = true;

                const options = {
                    specs: [
                        'fullscreen=yes',
                        'titlebar=yes',
                        'scrollbars=no'

                    ],
                    styles: [
                        'https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css',
                    ]
                }

                setTimeout(() => this.$htmlToPaper(accountID+'print',options,()=>{
                    this.PrintingMood =false;
                    this.LoadingSpinner = false;

                }), 1000);


            },
            EditTransactionAccount(item, status,parentAccount) {
                this.LoadingSpinner = true;

                let formData = new FormData();
                formData.append('_method',"PATCH");

                formData.append('edited_current_year_creditor',item.edited_current_year_creditor == null ? 0:item.edited_current_year_creditor);
                formData.append('edited_current_year_debtor',item.edited_current_year_debtor == null ? 0:item.edited_current_year_debtor);

                axios.post(route('accounts.transactions.update',item.id),formData)
                    .then(({data})=>{

                        console.log(data);
                        this.$toast.success('.','تم التعديل بنجاح',{timout:300});

                        parentAccount.FinalCredit = 0;
                        parentAccount.MonetaryItems.forEach(item => {


                            parentAccount.FinalCredit += (item.edited_current_year_creditor-item.edited_current_year_debtor)+(item.current_year_creditor - item.current_year_debtor);

                        });
                        this.LoadingSpinner = false;

                    })
                    .catch(error => {
                        this.$toast.error('.','حدث خطأ برجاء اعادة المحاولة',{timout:300});
                        this.LoadingSpinner = false;
                    })

                if(status == 'DebitEdit'){
                    item.EditCurrentYearDebtor = false;
                }else{
                    item.EditCurrentYearCreditor = false
                }
            },
            DownloadExcel(){
                const format = 'xlsx';
                const exportSelectedOnly = false;
                const filename = 'القوائم المالية';
                if(this.ExcelAccounts.length == 0){

                    this.PrepareForExcel();
                    this.LoadingSpinner = true;

                    var that = this;
                    setTimeout(function() {

                        that.$refs.grid.exportTable(format, exportSelectedOnly, filename);
                        that.LoadingSpinner = false;

                    }, 5000);

                }
                else{

                    this.$refs.grid.exportTable(format, exportSelectedOnly, filename);
                }


            },
            PrepareForExcel(){


                this.Accounts.forEach(FirstLVLAccount=>{

                    if(FirstLVLAccount.ClearanceNumber){

                        this.ExcelAccounts.push({
                            'Name':FirstLVLAccount.name,
                            'ClearanceNumber':FirstLVLAccount.ClearanceNumber,
                            'CurrentYearSum':FirstLVLAccount.CurrentYearSum,
                            'FirstPastYearSum':FirstLVLAccount.FirstPastYearSum,
                            'SecondPastYearSum':FirstLVLAccount.SecondPastYearSum,
                            'ThirdPastYearSum':FirstLVLAccount.ThirdPastYearSum,
                            'FourthPastYearSum':FirstLVLAccount.FourthPastYearSum
                        });

                    }else{

                        if(FirstLVLAccount.CurrentYearSum   ){
                            this.ExcelAccounts.push({
                                'Name':FirstLVLAccount.name,
                                'ClearanceNumber':'-',
                                'CurrentYearSum':'-',
                                'FirstPastYearSum':'-','SecondPastYearSum':'-','ThirdPastYearSum':'-','FourthPastYearSum':'-'});
                        }


                        FirstLVLAccount.second_level_accounts.forEach(SecondLVLAccount => {

                            if(SecondLVLAccount.ClearanceNumber){
                                this.ExcelAccounts.push({ 'Name':SecondLVLAccount.name,'ClearanceNumber':SecondLVLAccount.ClearanceNumber,'CurrentYearSum':SecondLVLAccount.CurrentYearSum,'FirstPastYearSum':SecondLVLAccount.FirstPastYearSum,'SecondPastYearSum':SecondLVLAccount.SecondPastYearSum,'ThirdPastYearSum':SecondLVLAccount.ThirdPastYearSum,'FourthPastYearSum':SecondLVLAccount.FourthPastYearSum});
                            }else{
                                this.ExcelAccounts.push({ 'Name':SecondLVLAccount.name,'ClearanceNumber':'-','CurrentYearSum':'-','FirstPastYearSum':'-','SecondPastYearSum':'-','ThirdPastYearSum':'-','FourthPastYearSum':'-'});


                                SecondLVLAccount.third_level_accounts.forEach(ThirdLVLAccount => {

                                    if(ThirdLVLAccount.ClearanceNumber){
                                        this.ExcelAccounts.push({ 'Name':ThirdLVLAccount.name,'ClearanceNumber':ThirdLVLAccount.ClearanceNumber,'CurrentYearSum':ThirdLVLAccount.CurrentYearSum,'FirstPastYearSum':ThirdLVLAccount.FirstPastYearSum,'SecondPastYearSum':ThirdLVLAccount.SecondPastYearSum,'ThirdPastYearSum':ThirdLVLAccount.ThirdPastYearSum,'FourthPastYearSum':ThirdLVLAccount.FourthPastYearSum});

                                    }

                                });
                                // Add Elmagmo3 of the Second LVL Account

                                this.ExcelAccounts.push({ 'Name':' مجموع '+SecondLVLAccount.name,'ClearanceNumber':'-','CurrentYearSum':SecondLVLAccount.CurrentYearSum,'FirstPastYearSum':SecondLVLAccount.FirstPastYearSum,'SecondPastYearSum':SecondLVLAccount.SecondPastYearSum,'ThirdPastYearSum':SecondLVLAccount.ThirdPastYearSum,'FourthPastYearSum':SecondLVLAccount.FourthPastYearSum});

                                // END ---- Add Elmagmo3 of the Second LVL Account


                            }

                        })
                        // Add Elmagmo3 of the First LVL Account
                        if(FirstLVLAccount.CurrentYearSum   ) {

                            this.ExcelAccounts.push({
                                'Name': ' مجموع '+FirstLVLAccount.name ,
                                'ClearanceNumber': '-',
                                'CurrentYearSum': FirstLVLAccount.CurrentYearSum,
                                'FirstPastYearSum': FirstLVLAccount.FirstPastYearSum,
                                'SecondPastYearSum': FirstLVLAccount.SecondPastYearSum,
                                'ThirdPastYearSum': FirstLVLAccount.ThirdPastYearSum,
                                'FourthPastYearSum': FirstLVLAccount.FourthPastYearSum
                            });
                        }
                        // END ---- Add Elmagmo3 of the First LVL Account


                    }

                });




            },

        }

    }
</script>

<style scoped>

</style>
