    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto">
        <!-- Sidebar user panel -->
        <div class="user-panel " style="padding-bottom: 50px">

            <div class="pull-left image" >
                <img src="{{asset('images/unknownAvatar.jpg')}}" style="height: 50px" class="img-circle" alt="User Image" />
            </div>

            <div class="info">
                <h4 class="float-right">
                    @auth
                    {{auth()->user()->name}}
                        @else
                    أسم الموظف / العميل
                    @endauth
                </h4>

            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        @auth

                <!-- if super admin links -->
                @if(auth()->user()->role == 'سوبر')
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{route('dashboard')}}">
                            <i class="fa fa-dashboard"></i> <span>الرئيسية</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('employees.index')}}">
                            <i class="fa fa-user"></i> <span>الموظفين</span>
                        </a>
                    </li>
                </ul>
                    @endif
                <!-- if Secertary links -->
                @if(auth()->user()->role == 'سكرتير')
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{route('Transactions.index')}}">
                            <i class="fa fa-folder-open"></i> <span>المعاملات</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-folder-open"></i> <span>الشركات المسجلة</span>
                        </a>
                    </li>
                </ul>
                    @endif

        @endauth
    </section>
    <!-- /.sidebar -->
