
<style> .status_active {
        background: #FE19B4 !important;
        border: none;
    }

    .order_status {
        width: 19%;
        background: #6A00A8;
        font-weight: bold;
        border: none;
        margin: 4px;
    }

    .btn .badge {
        position: relative;
        top: 2px;
        text-align: center;
        float: right;
        color: red;
    }

    @media (max-width: 776px) {
        .order_status {
            width: 48%;
            margin-bottom: 8px;
            background: #6a00a8;
            font-weight: bold;
            border: none;
            margin: 2px;
        }

        .btn .badge {
            position: relative;
            top: 2px;
            text-align: center;
            float: right;
            color: red;
        }
    } </style>
<div class="row" style="cursor: pointer;">


    <div class="col-12 col-lg-12 col-xl-12">
    <button onClick="orderStatus('Processing')" type="button"
            class="btn btn-primary order_status  "> Processing <span class="badge badge-light">     {{totalOrder('Processing')}}</span>
    </button>

    <button onClick="orderStatus('pending')" type="button"
            class="btn btn-primary order_status "> Payment Pending <span class="badge badge-light">     {{totalOrder('Payment Pending')}}</span>
    </button>

    <button onClick="orderStatus('On Hold')" type="button"
            class="btn btn-primary order_status ">On Hold<span class="badge badge-light">     {{totalOrder('On Hold')}}</span>
    </button>
    <button onClick="orderStatus('Pending Invoiced')" type="button"
            class="btn btn-primary order_status ">  Pending Invoiced  <span class="badge badge-light">     {{totalOrder('Pending Invoiced')}}</span>
    </button>
    <button onClick="orderStatus('Invoiced')" type="button"
            class="btn btn-primary order_status ">    Invoiced <span class="badge badge-light">     {{totalOrder('Invoiced')}}</span>
    </button>

    <button onClick="orderStatus('Completed')" type="button"
            class="btn btn-primary order_status ">Completed<span class="badge badge-light">     {{totalOrder('Completed')}}</span>
    </button>
    <button onClick="orderStatus('delivered')" type="button"
            class="btn btn-primary order_status ">  Delivered  <span class="badge badge-light">     {{totalOrder('delivered')}}</span>
    </button>
      

        <button onClick="orderStatus('return')" type="button"
                class="btn btn-primary order_status ">  Return  <span class="badge badge-light">     {{totalOrder('return')}}</span>
        </button>
    <button onClick="orderStatus('Canceled')" type="button"
            class="btn btn-primary order_status ">  Cancled  <span class="badge badge-light">     {{totalOrder('Canceled')}}</span>
    </button>
    <button onClick="orderStatus('All')" type="button"
                class="btn btn-primary order_status ">  All  <span class="badge badge-light">     {{totalOrder('All')}}</span>
        </button>

</div>


</div>