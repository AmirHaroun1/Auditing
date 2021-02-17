@extends('Layout')

@section('title')
    - الرئيسية سكرتارية
@endsection

@section('PageHeader')
    @if(auth()->user()->role == 'سكرتير')
        سكرتير - المعاملات

        @elseif(auth()->user()->role == 'مراجع فنى')
            مراجع فنى - المعاملات
    @endif
@endsection
@section('content')
    <div  style="padding-top: 50px">
        <div class="row">
            <div class="col-md-12">
                @if(auth()->user()->role == 'سكرتير')
                    <div class="box">

                        <div class="box-header">
                            <h2 class="box-title pb-3">أضافة معاملة</h2>
                                <h2 class="box-title pb-3">المعاملات المسندة</h2>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12">
                                <a class="btn btn-block btn-success btn-lg" href="{{route('Transactions.create')}}">أضافة معاملة جديدة</a>
                            </div>
                        </div>
                    </div>
                @endif

                <div id="app">
                    @if(auth()->user()->role == 'سكرتير')
                        <secretary-transactions-table></secretary-transactions-table>
                        @elseif(auth()->user()->role == 'مراجع فني')
                        <reviser-transactions-table></reviser-transactions-table>
                        @elseif(auth()->user()->role == 'مدقق')
                        <auditor-transactions-table></auditor-transactions-table>
                        @elseif(auth()->user()->role == 'مدير مراجعة')
                        <revising-manager-transactions-table></revising-manager-transactions-table>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

            <script src="{{ asset('js/app.js')}}"></script>

@endsection
