<?php
if (!empty($timetable)) {
    ?>
  
    <table class="table table-stripped">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
        <div class="dt-buttons btn-group btn-group2 ">   
             <a class="btn btn-default dt-button buttons-copy buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="Copy"><span><i class="fa fa-files-o"></i></span></a> 
             <a class="btn btn-default dt-button buttons-excel buttons-html5 " tabindex="0" aria-controls="DataTables_Table_0" href="<?php echo site_url('admin/timetable/mytimetable') ?> download" title="Excel"><span><i class="fa fa-file-excel-o"></i></span></a> 
             <a class="btn btn-default dt-button buttons-csv buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="CSV"><span><i class="fa fa-file-text-o"></i></span></a>
             <a class="btn btn-default dt-button buttons-pdf buttons-html5" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="PDF"><span><i class="fa fa-file-pdf-o"></i></span></a> 
             <a class="btn btn-default dt-button buttons-print" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="Print"><span><i class="fa fa-print"></i></span></a>
             <a class="btn btn-default dt-button buttons-collection buttons-colvis" tabindex="0" aria-controls="DataTables_Table_0" href="#" title="Columns"><span><i class="fa fa-columns"></i></span></a>
        </div>
     </div>
        <thead>
            <tr>
                <?php
                foreach ($timetable as $tm_key => $tm_value) {
                    ?>
                    
                  <th class="text text-center"><?php echo $tm_key; ?></th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($timetable as $tm_key => $tm_value) {
                    ?>
                    <td class="text text-center" width="14%">

                        <?php
                        if (!$timetable[$tm_key]) {
                            ?>
                            <div class="attachment-block clearfix">
                                <b class="text text-center"><?php echo $this->lang->line('not'); ?> <br><?php echo $this->lang->line('scheduled'); ?></b><br>
                            </div>
                            <?php
                        } else {
                            foreach ($timetable[$tm_key] as $tm_k => $tm_kue) {
                                ?>
                                <div class="attachment-block clearfix">
                                    <strong class="text-green"><?php echo $this->lang->line('class') ?>: <?php echo $tm_kue->class . "(" . $tm_kue->section . ")"; ?></strong><br>
                                    <b class="text-green"><?php echo $this->lang->line('subject') ?>: <?php echo $tm_kue->subject_name; if($tm_kue->subject_code!=''){ echo " (" . $tm_kue->subject_code . ")";}   ?>

                                    </b><br>

                                    <strong class="text-green"><?php echo $tm_kue->time_from ?></strong>
                                    <b class="text text-center">-</b>
                                    <strong class="text-green"><?php echo $tm_kue->time_to; ?></strong><br>

                                    <strong class="text-green"><?php echo $this->lang->line('room_no')?>: <?php echo $tm_kue->room_no; ?></strong><br>

                                </div>
                                <?php
                            }
                        }
                        ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
        </tbody>
    </table>
    <?php
} else {
    ?>
    <div class="alert alert-info">
        <?php echo $this->lang->line('no_record_found'); ?>
    </div>
    <?php
}
?>
