<template>
    <div>

        <div class="container">

            <div class="row">
                <!-- /بيانات المعاملة -->
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box cursor-pointer"  data-toggle="tab" href="#TransactionData" role="tab"  aria-selected="true">
                        <span class="info-box-icon bg-green"><i class="fa  fa-star-o"></i></span>
                        <div class="info-box-content">
                            <h4 class="font-weight-bold" style="padding-top:10px;" >بيانات المعاملة</h4>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                    <!-- بيانات المعاملة/. -->

                </div>
                <!-- السجلات -->

                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box cursor-pointer" data-toggle="tab" href="#TradeRegistersDate" role="tab"  aria-selected="true" >
                        <span class="info-box-icon bg-green"><i class="fa  fa-newspaper-o"></i></span>
                        <div class="info-box-content">
                            <h4 class="font-weight-bold" style="padding-top:10px" >السجلات</h4>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div>

                <!-- السجلات /.-->

                <!-- ضابط الأتصال -->
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box cursor-pointer" data-toggle="tab" href="#AgentData" role="tab"  aria-selected="true" >
                        <span class="info-box-icon bg-green"><i class="fa  fa-user"></i></span>
                        <div class="info-box-content">
                            <h4 class="font-weight-bold" style="padding-top:10px;" >ضابط الأتصال</h4>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div>
                <!-- ضابط الأتصال/. -->

                <!-- الملفات -->
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box cursor-pointer" data-toggle="tab" href="#DocumentsData" role="tab"  aria-selected="true">
                        <span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>
                        <div class="info-box-content">
                            <h4 class="font-weight-bold" style="padding-top:10px;" >الملفات</h4>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div>
                <!-- الملفات/. -->

                <!-- طباعة خطاب الأرتباط -->
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box cursor-pointer" >
                        <span class="info-box-icon bg-green"><i class="fa  fa-star-o"></i></span>
                        <div class="info-box-content">
                            <h4 class="font-weight-bold" style="padding-top:10px;" >طباعة خطاب الأرتباط</h4>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div>
                <!-- طباعة خطاب الأرتباط/. -->

            </div>

        </div>
        <div class="container box">
            <div class="row">
                <div class="box-header">
                    <h2 class="pb-3">بيانات السجل الرئيسي</h2>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "EditTransaction.vue"
    }
</script>

<style scoped>

</style>
