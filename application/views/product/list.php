<div class="container-fluid">
    <div class="row">
        <div class="col-12"> 
                <div class="d-flex">
                    <select id="order_type">
                        <option value="">Nincs sorrend</option>
                        <option value="name_asc">Név szerint növekvő</option>
                        <option value="name_desc">Név szerint csökkenő</option>
                        <option value="price_asc">Ár szerint növekvő</option>
                        <option value="price_desc">Ár szerint csökkenő</option>
                    </select>
                    <select id="limit" disabled>
                        <option value="3">3</option>
                        <option value="5" selected>5</option>
                        <option value="8">8</option>
                    </select>
                    <input type="text" placeholder="Keresés" name = "search" id="listsearch" style="margin-left: auto;"/>
                </div>

            <div id="product_table">
                <?php
                    $this->load->view('product/product_list');
                  ?>
            </div>

            <div id="pagdiv" class="">
                <input type="hidden" id="current_page" value="1">
                <span class="pagination_div">
                    <div class="" style="justify-content: space-around;display: flex;">
                        <button onclick="change_page('back','back', <?php echo $all_data; ?>)" class="btn btn-info">&laquo;</button>
                        <button onclick="change_page('next','next', <?php echo $all_data; ?>)" class="btn btn-info">&raquo;</button>
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
    var current_page = 0;
    function change_page(active_page, next_offset, all){
        if (next_offset === 'back' && current_page >= 1)
        {
            current_page = current_page - 1;
        }
        if (next_offset === 'next' && current_page < all)
        {
            current_page = current_page + 1;
        }
        $.ajax({ 
            url:'<?php echo base_url('products/list')?>',
            data : {
                search : $('#listsearch').val().trim(),
                limit: <?php echo $per_page; ?>,
                offset : <?php echo $per_page; ?> * current_page,
                order_type: $('#order_type').val()
            },
            method:'GET',
            success:function(data){
                $('#table').html(data); 
                $('.all_page').removeClass('active');
                $('.pager_' + active_page).addClass('active');
                $('#current_page').val(active_page);
            },
            error:function(data){
            }
        });
    }
    $('#listsearch').keyup(function(){
        var search = $(this).val();
        if(search != '')
        {
            change_page();
        }else{
            change_page();
        }
    });
//    $(document).on("change", "#limit", function () {
//        change_page();
//    });
    $(document).on("change", "#order_type", function () {
        change_page();
    });


</script>
