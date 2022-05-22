<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <img src="<?php echo $product->image; ?>">
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="d-flex flex-column">
                <span>Termék neve: <?php echo $product->name; ?></span>
                <span>Leírás: <?php echo $product->description; ?></span>
                <span>Ár: <?php echo $product->price; ?></span>
                <span>Akciós ár: <?php echo $product->sale_price; ?></span>
                <span>Készlet: <?php echo $product->stock; ?></span>
                <span>Elérhetőség: <?php echo $product->available; ?></span>
                <div class="max_width_150">
                    <div class="d-flex d-inline">
                        <span type="button" class="btn btn-default amountbtn" onclick="minus()">
                            <i class="fas fa-minus"></i>
                        </span>
                        <input disabled id="amount" type="text" value="1" class="qty-input cart-item-quantity form-control">
                        <span type="button" class="btn btn-default amountbtn" onclick="plus(<?php echo $product->stock; ?>)">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <button class="btn btn-default cart_btn" id="add_to_cart">
                        Kosárba rakom
                    </button>
                </div>
                <h4 class="d-none" id="sucess_cart">Sikeresen hozzáadta a kosárhoz</h4>
            </div>
        </div>
    </div>
</div>

<script language="javascript" type="text/javascript">
    function plus(stock){
        if((Number($("#amount").val()) + 1) <= stock){
            $("#amount").val(Number($("#amount").val()) + 1);
        }
    }

    function minus(){
        if((Number($("#amount").val()) - 1) > 0){
            $("#amount").val(Number($("#amount").val()) - 1);
        }
    }
    $(document).on('click','#add_to_cart', function() {
        var size_val = $('.size .selectedli_color').text();
        var color_val = $('.color .selectedli').text();
        var id = <?php if (isset($_SESSION['username'])){
                echo $_SESSION['user_id']; 
            } else {
                echo 0;
            } ?>;
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('add_to_cart')?>',
            data: {
                'amount': $("#amount").val(),
                'id': '<?php echo $product->id; ?>',
                'name': '<?php echo $product->name; ?>',
                'price': '<?php echo $product->price; ?>',
                'sale_price': '<?php echo $product->sale_price; ?>',
                'user_id': id
            },
            success: function (msg) {
                $('#add_to_cart').addClass("d-none");
                $('#sucess_cart').removeClass("d-none").addClass("d-block");
                $('#cart_value').html(msg);
            }
        });
    });
</script>

