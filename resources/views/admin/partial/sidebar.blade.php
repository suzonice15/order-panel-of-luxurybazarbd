<!-- Brand Logo -->
<a href="{{url('/')}}" class="brand-link">
    <img src="https://cdn.pixabay.com/photo/2015/03/04/22/35/head-659651_960_720.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Admin Panel</span>
</a>
<?php
$status=Session::get("status");
?>
<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://cdn.pixabay.com/photo/2015/03/04/22/35/head-659651_960_720.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
    </div>

    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       
    <li class="nav-item">
            <a href="{{url('/')}}/admin/dashboard" class="nav-link">
            <i class="nav-icon  fas fa-home"></i>                
                <p>               Dashboard
                </p>
            </a>
        </li>
         
        <li class="nav-item ">
            <a href="#" class="nav-link ">
                <i class="nav-icon fa  fa-shopping-bag"></i>
                <p>
                    Orders
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
            
            <li class="nav-item">
                    <a href="{{url('/')}}/admin/order/create" class="nav-link">
                    <i class="fas fa-arrow-circle-right nav-icon"></i>
                        <p>Add New </p>
                    </a>
                </li>    
                <li class="nav-item">
                    <a href="{{url('/')}}/admin/order" class="nav-link">
                    <i class="fas fa-arrow-circle-right nav-icon"></i>
                        <p>Orders List</p>
                    </a>
                </li>    
                <li class="nav-item">
                    <a href="{{url('/')}}/admin/order/invoiceList" class="nav-link">
                    <i class="fas fa-arrow-circle-right nav-icon"></i>
                        <p>Invoice List</p>
                    </a>
                </li>     
				
				 <!-- <li class="nav-item">
                    <a href="{{url('/')}}/admin/orderStatus/report" class="nav-link">
                        <i class="fas fa-arrow-circle-right nav-icon"></i>
                        <p>Order Status Report </p>
                    </a>
                </li> -->

				
                @if(Auth::user()->role_id !=3)
                <!-- <li class="nav-item">
                    <a href="{{url('/')}}/admin/product/report" class="nav-link">
                    <i class="fas fa-arrow-circle-right nav-icon"></i>
                        <p>Product report </p>
                    </a>
                </li>

                
                    <li class="nav-item">
                        <a href="{{url('/')}}/admin/currentMonthStaffReport" class="nav-link">
                            <i class="fas fa-arrow-circle-right nav-icon"></i>
                            <p>Current Month Staff Report </p>
                        </a>
                    </li> -->

                    @endif




            </ul>
        </li>


        <li class="nav-item ">
            <a href="#" class="nav-link ">
                <i class="nav-icon fa  fa-car"></i>
                <p>
                    Courier Report
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">



                <li class="nav-item">
                    <a href="{{url('/')}}/admin/order/sendProductToRedex" class="nav-link">
                        <i class="fas fa-arrow-circle-right nav-icon"></i>
                        <p>Order Send To Redex </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a  href="{{url('/')}}/admin/order/getSinglePercel" class="nav-link">
                        <i class="fas fa-arrow-circle-right nav-icon"></i>
                        <p>Parcel  Tracking</p>
                    </a>
                </li>

            </ul>
        </li> 

        <li class="nav-item ">
            <a href="#" class="nav-link ">
            <i class="nav-icon far fa-cogs"></i> 
                
                <p>
                    Setting
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview"> 
                <li class="nav-item">
                    <a href="{{url('/')}}/admin/cache-clean" class="nav-link">
                    <i class="fas fa-arrow-circle-right nav-icon"></i>
                        <p>Catche Removed</p>
                    </a>
                </li>               

            </ul>
        </li>



    </ul>
</nav>
</div>
<!-- /.sidebar -->

<script type="text/javascript">
 var url = window.location;
const allLinks = document.querySelectorAll('.nav-item a');
const currentLink = [...allLinks].filter(e => {
  return e.href == url;
});

currentLink[0].classList.add("active")
currentLink[0].closest(".nav-treeview").style.display="block";
currentLink[0].closest(".has-treeview").classList.add("active");
</script>