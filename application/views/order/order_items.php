<div id="table" class="table-responsive">
    <table  class="table table-striped table-bordered" style="margin-bottom: 0">
        <thead>
            <tr>
                <th>Terméknév</th>
                <th>Ár</th>
                <th>Akciós ár</th>
                <th>Mennyiség</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item) { ?>
                <tr>
                    <td>
                        <?php echo $item->name; ?>
                    </td>
                    <td>
                        <?php echo $item->price; ?>
                    </td>
                    <td>
                        <?php echo $item->sale_price; ?>
                    </td>   
                    <td>
                        <?php echo $item->amount; ?>
                    </td>   
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>