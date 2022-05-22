<div id="table" class="table-responsive">
    <table  class="table table-striped table-bordered" style="margin-bottom: 0">
        <thead>
            <tr>
                <th>Terméknév</th>
                <th>Leírás</th>
                <th>Ár</th>
                <th>Akciós ár</th>
                <th>Raktárkészlet</th>
                <th>Elérhetőség</th>
                <th>Kép</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $item) { ?>      
            <tr>
                <td><?php echo $item->name; ?></td>
                <td><?php echo $item->description; ?></td>
                <td><?php echo $item->price; ?></td>
                <td><?php echo $item->sale_price; ?></td>
                <td><?php echo $item->stock; ?></td>
                <td><?php echo $item->available; ?></td>
                <td>
                    <img class="max_width_height_100" src="<?php echo $item->image; ?>">
                </td>
                <td>
                    <a class="btn btn-default" href="<?php echo base_url('product/'.$item->id) ?>">
                        Megnézem
                    </a>
                </td>     
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
