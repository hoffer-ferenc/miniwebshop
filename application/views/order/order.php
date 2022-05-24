<div id="table" class="table-responsive">
    <table  class="table table-striped table-bordered" style="margin-bottom: 0">
        <thead>
            <tr>
                <th>Rend. id</th>
                <th>Név</th>
                <th>Email</th>
                <th>Cím</th>
                <th>Szállítás</th>
                <th>Rend. összeg</th>
                <th>Tételek</th>
                <th>Törlés</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $item) { ?>      
                <tr>
                    <td>
                        <?php echo $item->idorder; ?>
                    </td>
                    <td>
                        <?php echo $item->name; ?>
                    </td>
                    <td>
                        <?php echo $item->email; ?>
                    </td>   
                    <td>
                        <?php echo $item->zip_code.' '.$item->city.' '.$item->address; ?>
                    </td>   
                    <td>
                        <?php echo $item->shipping; ?>
                    </td>   
                    <td>
                        <?php echo $item->order_total; ?>
                    </td>
                    <td>
                        <a class="btn btn-default" href="<?php echo base_url('order/'.$item->idorder) ?>">
                            Megnézem
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-default" onclick="deleteOrder('<?php echo $item->idorder; ?>')">
                            Törlés
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    function deleteOrder(id){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('delete_order')?>', 
            data: {
                'idorder': id
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