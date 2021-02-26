<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('academics'); ?> <small><?php echo $this->lang->line('student_fees1'); ?></small>        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('add_room_no'); ?></h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <div class="mailbox-controls">                          
                            <a href="<?php echo base_url(); ?>room_nos/create" class="btn btn-primary btn-sm"  data-toggle="tooltip" title="<?php echo $this->lang->line('add_room_no'); ?>">
                                <i class="fa fa-plus"></i><?php echo $this->lang->line('add_session'); ?>
                            </a>
                            <div class="pull-right">
                            </div>
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <td><?php echo $this->lang->line('room_no'); ?></td>
                                        <td class="mailbox-name"><a href="<?php echo base_url(); ?>room_nos/view/<?php echo $room_no['id'] ?>"> <?php echo $room_no['room_no'] ?></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="mailbox-controls">   
                            <div class="pull-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>
</div>