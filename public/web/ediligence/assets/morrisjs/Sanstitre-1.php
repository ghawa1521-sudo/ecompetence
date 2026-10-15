<script src="<?php echo base_url(); ?>bootstrap/morrisjs/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/morrisjs/morris.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/morrisjs/morris-data.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/morrisjs/sb-admin-2.js"></script>

<link href="<?php echo base_url(); ?>bootstrap/morrisjs/morris.css" rel="stylesheet">

<h3><b><font color="#406F09"><span class="glyphicon glyphicon-briefcase"></span> APPLICATION E-DILIGENCE</font></b></h3>
<br />
<div>
  APPLICATION SPECIALISEE DANS LE TRAITEMENT DES COURRIERS
</div>
<br />
<div id="wrapper">
<div id="page-wrapper">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Zone graphique tableau de bord
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Action</a>
                                </li>
                                <li><a href="#">Another action</a>
                                </li>
                                <li><a href="#">Something else here</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-area-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Panel des résultats
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <i class="fa fa-comment fa-fw"></i> Courrier arrivé
                            <span class="pull-right text-muted small"><em><?php echo $board['arrivee'][0]; ?></em>
                            </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-twitter fa-fw"></i> Diligence imputé
                            <span class="pull-right text-muted small"><em><?php echo $board['impute'][0]; ?></em>
                            </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-envelope fa-fw"></i> Diligence en souffrance
                            <span class="pull-right text-muted small"><em><?php echo $board['souffrance'][0]; ?></em>
                            </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-tasks fa-fw"></i> Diligence traité
                            <span class="pull-right text-muted small"><em><?php echo $board['traite'][0]; ?></em>
                            </span>
                        </a>
                      
                    </div>
                   
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
           
            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->
    
<div class="panel panel-default">
<div class="panel-heading">
    <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
</div>
<div class="panel-body">
    <div id="morris-donut-chart"></div>
    <a href="#" class="btn btn-default btn-block">View Details</a>
</div>
<!-- /.panel-body -->
</div>



