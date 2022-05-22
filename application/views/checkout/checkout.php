<div class="container">
    <?php
    if ($this->session->flashdata('errors')){
        echo '<div class="alert alert-danger">';
        echo $this->session->flashdata('errors');
        echo "</div>";
    }
    ?>
    <div class="">
        <form class="form-horizontal d-md-flex" method="post" action="<?php echo base_url('save_checkout');?>">
        <div class="col-md-6 col-sm-12">
            <!--REVIEW ORDER-->
            <div class="panel panel-info">
                <div class="ph">
                    Megrendelés összegzés
                </div>
                <div class="panel-body">
                    <div>
                        <?php foreach ($this->cart->contents() as $items){ ?>
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-3">

                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <div class="col-sm-12"><?php echo $items['name']; ?></div>
                                <div class="col-sm-12"><small>Mennyiség: <?php echo $items['qty']; ?></small></div>
                            </div>
                            <div class="text-right">
                                <h6><?php echo $items['price']; ?><span> Ft</span></h6>
                            </div>
                            <div class="text-right">
                                <a id="delete_cart_item" onclick="deleteItem('<?php echo $items['rowid']; ?>')" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>
                        </div><div class="form-group"><hr/></div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <small>Rendelés összege: </small>
                            <div><span id="cart_total"><?php echo $this->cart->total(); ?></span><span> Ft</span></div>
                        </div>
                        <div class="col-sm-12">
                            <small>Szállítási költség: </small>
                            <div><span>1500</span><span> Ft</span></div>
                        </div>
                        <div class="col-sm-12"><br>
                            <strong>Teljes összeg: </strong>
                            <div><span id="full_cart_total"><?php $cart = $this->cart->total();$shipping=1500; $total=$shipping+$cart;echo $total ?></span><span> Ft</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--REVIEW ORDER END-->
        </div>
        <div class="col-md-6 col-sm-12">
            <!--SHIPPING METHOD-->
            <div class="panel panel-info">
                <div class="ph">Számla adatok</div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <h4>Rendelés adatok</h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <strong id="pers_name">Név:</strong>
                            <input type="text" name="name" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-12">
                            <strong>Irányítószám: </strong>
                            <div class="">
                                <input type="text" name="zip_code" class="form-control" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-12">
                        <strong>Város:</strong>
                        <div><input type="text" name="city" class="form-control" value="" /></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12"><strong>Utca/házszám: </strong></div>
                        <div class="col-md-12">
                            <input type="text" name="address" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12"><strong>Telefonszám: </strong></div>
                        <div class="col-md-12">
                            <input type="text" name="tel" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12"><strong>Email cím: </strong></div>
                        <div class="col-md-12">
                            <input type="text" name="email" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-sm-12">
                            <button type="submit" class="btn btn-primary btn-submit-fix">Rendelés leadása</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--SHIPPING METHOD END-->
        </div>
        </form>
    </div>
    <div class="row cart-footer">
    </div>
</div>
<script>
    function deleteItem(id){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('delete_cart_item')?>', 
            dataType:'json',
            data: {
                'rowid': id
            },
            success:function(data){
                window.location.reload();
            },
            error:function(data){
                //todo
            }
        });
    }
</script>
