

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Ventas/historial_compro_eliminados">
                <input type="hidden" id="enviar_registro" name="enviar_registro" value="1">
                <div class="row">
                    <div class="col-lg-2">
                        <label>Tipo de Venta</label>
                        <select  id="tipo_venta" name="tipo_venta" class="form-control">
                            <option <?= ($tipo_venta == "")?'selected':''; ?> value="">Seleccionar...</option>
                            <option <?= ($tipo_venta == "03")?'selected':''; ?> value="03">BOLETA</option>
                            <option <?= ($tipo_venta == "01")?'selected':''; ?> value="01">FACTURA</option>
                            <option <?= ($tipo_venta == "20")?'selected':''; ?> value="20">NOTA DE VENTA</option>
                            <option <?= ($tipo_venta == "07")?'selected':''; ?> value= "07">NOTA DE CRÉDITO</option>
                            <option <?= ($tipo_venta == "08")?'selected':''; ?> value= "08">NOTA DE DÉBITO</option>
                        </select>
                    </div>
                    <div class="col-lg-2" style="display: none">
                        <label>Cajero</label>
                        <select class="form-control" name="id_usuario" id="id_usuario">
                            <option value="">Seleccione...</option>
                            <?php
                            (isset($usuario_))?$user=$usuario_->id_usuario:$user=0;
                            foreach($usuario as $l){
                                ($l->id_usuario == $user)?$sele='selected':$sele='';
                                ?>
                                <option value="<?php echo $l->id_usuario;?>" <?= $sele; ?>><?php echo $l->persona_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-md-6">
                        <label for="">Fecha de Inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?= $fecha_ini; ?>">
                    </div>
                    <div class="col-lg-2 col-sm-6 col-md-6">
                        <label for="">Fecha Final</label>
                        <input type="date" id="fecha_final" name="fecha_final" class="form-control" value="<?= $fecha_fin; ?>">
                    </div>
                    <div class="col-lg-2 col-sm-12 col-md-12" style="text-align: center">
                        <button style="margin-top: 34px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-12" style="display: none">
                        <label for="" style="margin-top: 20px;color: black;">COMPROBANTES ELIMINADOS : <span style="color: red;"><?= count($ventas_cant);?></span><br>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <?php
                        if($filtro) {
                            ?>
                            <div class="card-header py-3">
                                <h5>TIPO COMPROBANTE: <span class='text-uppercase font-weight-bold'>
                                    <?php
                                    if($tipo_venta == "03"){
                                        echo "BOLETA";
                                    }elseif($tipo_venta == "01"){
                                        echo "FACTURA";
                                    }elseif($tipo_venta == "20"){
                                        echo "NOTA DE VENTA";
                                    }elseif($tipo_venta == "07"){
                                        echo "NOTA DE CRÉDITO";
                                    }elseif($tipo_venta == "08"){
                                        echo "NOTA DE DÉBITO";
                                    }else{
                                        echo 'TODOS';
                                    }
                                    ?></span>
                                    | FECHA DEL: <span><?= (($fecha_ini != ""))?date('d-m-Y', strtotime($fecha_ini)):'--'; ?></span> AL <span><?= (($fecha_fin != ""))?date('d-m-Y', strtotime($fecha_fin)):'--'; ?></span>
                                    | Total SOLES: <span id="total_soles"></span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th style="text-align: center">#</th>
                                            <th style="text-align: center">Fecha Emision</th>
                                            <th style="text-align: center">Empresa</th>
                                            <th style="text-align: center">Comprobante</th>
                                            <th style="text-align: center">Serie y Correlativo</th>
                                            <th style="text-align: center">Cliente</th>
                                            <th style="text-align: center">Total</th>
                                            <th style="text-align: center">Motivo</th>
                                            <th style="text-align: center">Fecha Anulacion</th>
                                            <th style="text-align: center">Usuario Eliminación</th>
                                            <th style="text-align: center">Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $a = 1;
                                        $total = 0;
                                        $total_soles = 0;
                                        foreach ($ventas as $al){
                                            $buscar_usuario = $this->ventas->buscar_usuario($al->venta_usuario_eli);
                                            $stylee="style= 'text-align: center;'";
                                            if ($al->anulado_sunat == 1){
                                                $stylee="style= 'text-align: center'";
                                            }

                                            if($al->venta_tipo == "03"){
                                                $tipo_comprobante = "BOLETA";
                                                if($al->anulado_sunat == 1){
                                                    $total_soles = round($total_soles + $al->venta_total, 2);
                                                }
                                            }elseif ($al->venta_tipo == "01"){
                                                $tipo_comprobante = "FACTURA";
                                                if($al->anulado_sunat == 1){
                                                    $total_soles = round($total_soles + $al->venta_total, 2);
                                                }
                                            }elseif($al->venta_tipo == "07"){
                                                $tipo_comprobante = "NOTA DE CRÉDITO";
                                                /*if(($al->anulado_sunat == 0 AND $al->venta_codigo_motivo_nota != "01")){
                                                    $total_soles = round($total_soles - $al->venta_total, 2);
                                                }*/
                                            }elseif($al->venta_tipo == "08"){
                                                $tipo_comprobante = "NOTA DE DÉBITO";
                                                if($al->anulado_sunat == 1){
                                                    $total_soles = round($total_soles + $al->venta_total, 2);
                                                }
                                            }else{
                                                $tipo_comprobante = "--";
                                            }
                                            $estilo_mensaje = "style= 'color: red; font-size: 14px;'";
                                            if($al->venta_respuesta_sunat == NULL){
                                                $mensaje = "Sin Enviar a Sunat";

                                            }else{
                                                $mensaje = $al->venta_respuesta_sunat;
                                            }
                                            if($al->id_tipodocumento == 4){
                                                $cliente = $al->cliente_razonsocial;
                                            }else{
                                                $cliente = $al->cliente_nombre;
                                            }
                                            ?>
                                            <tr <?= $stylee?>>
                                                <td style="text-align: center"><?= $a;?></td>
                                                <td style="text-align: center"><?= date('d-m-Y H:i:s', strtotime($al->venta_fecha));?></td>
                                                <td style="text-align: center"><?= $al->empresa_razon_social; ?></td>
                                                <td style="text-align: center"><?= $tipo_comprobante;?></td>
                                                <td style="text-align: center"><?= $al->venta_serie. '-' .$al->venta_correlativo;?></td>
                                                <td style="text-align: center">
                                                    <?= $al->cliente_numero;?><br>
                                                    <?= $cliente;?>
                                                </td>
                                                <td style="text-align: center">
                                                    <?= $al->simbolo.' '.$al->venta_total;?>
                                                </td>
                                                <td <?= $estilo_mensaje;?>><?= ($al->venta_motivo_eli==Null)?'----':$al->venta_motivo_eli ?></td>
                                                <td <?= $estilo_mensaje;?>><?= date('d-m-Y H:i:s',strtotime($al->venta_fecha_eli))?></td>
                                                <td <?= $estilo_mensaje;?>><?= (empty($buscar_usuario->persona_nombre))?'---':$buscar_usuario->persona_nombre?> <?= $buscar_usuario->persona_apellido_paterno?></td>
                                                <td style="text-align: left">
                                                    <a target="_blank" type="button" title="Ver detalle" class="btn btn-sm btn-primary" style="color: white" href="<?php echo _SERVER_. 'Ventas/ver_detalle_venta/' . $al->id_venta;?>" ><i class="fa fa-eye ver_detalle"></i></a>
                                                    <?php
                                                    if($al->anulado_sunat == "0" && ($al->venta_tipo_envio == "0" || $al->venta_tipo_envio == "1") && $al->venta_tipo != '03'){ ?>
                                                        <a id="btn_enviar<?= $al->id_venta;?>" type="button" title="Enviar a Sunat" class="btn btn-sm btn-success btne" style="color: white" onclick="preguntar('¿Está seguro que desea enviar a la Sunat este Comprobante?','enviar_comprobante_sunat','Si','No',<?= $al->id_venta;?>)"><i class="fa fa-check margen"></i></a>
                                                        <?php
                                                    }
                                                    if(($al->venta_tipo == "03" || $al->venta_tipo == "01") and $al->anulado_sunat == "0"){
                                                        ?>
                                                        <?php
                                                        if($role == 2 || $role == 3 || $role == 7) {
                                                            ?>
                                                            <a target="_blank" type="button" data-toggle="modal" data-target="#eliminar_venta" class="btn btn-sm btn-danger btne" style="color: white" onclick="llenar_id_venta(<?=$al->id_venta?>)" ><i class="fa fa-ban"></i></a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                    }
                                                    //boton para cambiar de estado si sale error 1033 (informado anteriormente)
                                                    $error1 = '1033';
                                                    $error2 = '1032';
                                                    $respuesta = $al->venta_respuesta_sunat;
                                                    $error1033 = strrpos($respuesta, $error1);
                                                    $error1032 = strrpos($respuesta, $error2);
                                                    if(!empty($error1033)){
                                                        ?>
                                                        <a target="_blank" type="button" id="btn_actualizar_estado<?= $al->id_venta;?>" class="btn btn-sm btn-warning btne" style="color: white" onclick="cambiarestado_enviado(<?= $al->id_venta ?>)" ><i class="fa fa-circle-o-notch"></i></a>
                                                        <?php
                                                    }elseif(!empty($error1032)){
                                                        ?>
                                                        <a target="_blank" type="button" id="btn_actualizar_estado<?= $al->id_venta;?>" class="btn btn-sm btn-warning btne" style="color: white" onclick="cambiarestado_anulado(<?= $al->id_venta ?>)" ><i class="fa fa-circle-o-notch"></i></a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $a++;
                                            $total = $total + $al->venta_total;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <a id="btnExportar" href="<?= _SERVER_ ; ?>index.php?c=Ventas&a=excel_compro_eliminados&tipo_venta=<?= $_POST['tipo_venta']?>&fecha_inicio=<?= $_POST['fecha_inicio']?>&fecha_final=<?= $_POST['fecha_final']?>&id_empresa=<?= $_POST['id_empresa']?>" target="_blank" class="btn btn-success" style="width: 100%"><i class="fa fa-download"></i> Generar Excel</a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>


                </div>
            </div>



        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>venta.js"></script>

<script>
    $(document).ready(function(){
        var total_rs = <?= $total_soles; ?>;
        $("#total_soles").html("<b>"+total_rs+"</b>");
    });

</script>