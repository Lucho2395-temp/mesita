
<div class="modal fade" id="agregar_pedido_nuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 70% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="form-group col-lg-8 col-md-7 col-xs-7 col-sm-7">
                        <input autocomplete="off" name="parametro" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Buscar Productos">
                    </div>
                    <div class="form-group col-lg-4 col-md-5 col-xs-5 col-sm-5">
                        <a type="submit" onclick="productos_nuevo()" class="btn btn-success" style="width: 80%; color:white"><i class="fa fa-search"></i> Buscar</a>
                    </div>
                </div>
                <div class="row">
                    <div id="producto_nuevo" class="table-responsive">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 col-sm-6 col-md-6 col-xs-6">
                        <div id="ver_seleccion" class="col-lg-6 col-sm-10 col-md-10 col-xs-10">
                            <label>Producto <span id ="producto_nombre_" style="color: black; font-size: 18pt;"></span> <!--: <span id ="comanda_detalle_precio_"></span>--></label>
                        </div>

                    </div>
                </div>
            </div>
            <form class="" enctype="multipart/form-data" id="guardar_pedido_nuevo">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="display:none;">
                            <?php
                            foreach ($familia as $f){
                                $productos_familia = $this->pedido->listar_productos_x_familia($f->id_producto_familia);
                                ?>
                                <h3 data-toggle="collapse" href="#tipo_<?= $f->id_producto_familia;?>"><?= $f->producto_familia_nombre?><i class="fa fa-arrow-down" style="float: right"></i></h3><br>

                                <div id="tipo_<?= $f->id_producto_familia;?>" class="collapse">
                                    <table class='table table-bordered' width='100%'>
                                        <thead class='text-capitalize'>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($productos_familia as $pf){
                                            $anho = date('Y');
                                            if($anho == "2021"){
                                                $icbper = 0.30;
                                            }elseif($anho == "2022"){
                                                $icbper = 0.40;
                                            }else{
                                                $icbper = 0.50;
                                            }
                                            $op_gravadas=0.00;
                                            $op_exoneradas=0.00;
                                            $op_inafectas=0.00;
                                            $op_gratuitas=0.00;
                                            $igv=0.0;
                                            $igv_porcentaje=0.18;
                                            if($pf->producto_precio_codigoafectacion == 10){
                                                $op_gravadas = $pf->producto_precio_venta;
                                                $igv = $op_gravadas * $igv_porcentaje;
                                                $total = $op_gravadas + $igv;
                                            }else{
                                                $total = $pf->producto_precio_venta;
                                            }
                                            if($pf->id_receta == "0"){
                                                $total = $total + $icbper;
                                            }
                                            ?>
                                            <tr>
                                                <td><?=$pf->producto_nombre?></td>
                                                <td><?=$total ?></td>
                                                <td>
                                                    <button class='btn btn-success' onclick="guardar_pedido_nuevo(<?=$pf->id_producto?>,'<?=$pf->producto_nombre?>','<?=$total?>')"><i class='fa fa-check'></i></button>
                                                    <a class="btn btn-primary" href="<?= _SERVER_ . $pf->producto_foto?>" target="_blank"><i class="fa fa-eye"></i></a>
                                                <td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            }
                            ?>
                        </div>



                        <div id="mostrar">
                            <div class="row">
                                <div class="col-lg-2  col-sm-6 col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="id_producto" name="id_producto">
                                        <input type="hidden" class="form-control" id="id_comanda" name="id_comanda" value="<?= $ultimo_valor_;?>">
                                        <input type="hidden" class="form-control" id="producto_nombre" name="producto_nombre">
                                        <!--<input type="hidden" class="form-control" id="comanda_detalle_precio" name="comanda_detalle_precio">-->
                                        <input type="hidden" class="form-control" id="comanda_detalle_total" name="comanda_detalle_total">
                                        <input type="hidden" class="form-control" id="id_mesa" name="id_mesa" value="<?= $id;?>">
                                        <input type="hidden" id="contenido_pedido" name="contenido_pedido">
                                        <label class="col-form-label">Cantidad</label>
                                        <input type="number" value="1" class="form-control" id="comanda_detalle_cantidad" name="comanda_detalle_cantidad">
                                    </div>
                                </div>
                                <div class="col-lg-2  col-sm-6 col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Tipo Entrega</label>
                                        <select class="form-control" id= "comanda_detalle_despacho" name="comanda_detalle_despacho">
                                            <option value="SALON">Salon</option>
                                            <option value="PARA LLEVAR">Para llevar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-md-6 col-xs-6">
                                    <label for="">Precio</label>
                                    <input type="text" class="form-control" id="comanda_detalle_precio" name="comanda_detalle_precio">
                                </div>
                                <div class="col-lg-4 col-sm-8 col-md-8 col-xs-8">
                                    <div class="form-group">
                                        <label class="col-form-label">Observacion</label>
                                        <textarea rows="3" class="form-control" type="text" id="comanda_detalle_observacion" name="comanda_detalle_observacion" maxlength="200" placeholder="Ingrese Alguna Observacion...">-</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-md-3 col-xs-3">
                                    <a style="margin-top: 50px; color: white" class='btn btn-primary' data-toggle='modal' onclick='add_pedido_nuevo()' data-target='#asignar_pedido'><i class='fa fa-check'></i> Agregar</a>
                                </div>
                                <div class="container-fluid">
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                        <div class="table-responsive">
                                            <table id="" class="table table-bordered" style="background: antiquewhite;">
                                                <thead>
                                                <tr style="font-weight: bold;text-align: center">
                                                    <td>PRODUCTO</td>
                                                    <td>PU</td>
                                                    <td>CANT</td>
                                                    <td>ENTR</td>
                                                    <td>OBS</td>
                                                    <td>TOTAL</td>
                                                    <td>ACCIÓN</td>
                                                </tr>
                                                </thead>
                                                <tbody id="contenido_detalle_compra">
                                                </tbody>
                                                <!--<tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>-->
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td><span id="comanda_total_">S/ 0.00</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-guardar_nuevo"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cambiar_mesa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Mesa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                     <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-form-label">Elegir Mesa</label>
                        <select class="form-control" id="id_mesa_nuevo" name="id_mesa_nuevo">
                            <option value="">Seleccionar Mesa</option>
                            <?php
                            foreach ($mesas as $m){
                                ?>
                                <option value="<?php echo $m->id_mesa;?>"><?php echo $m->mesa_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="preguntar('¿Está seguro que desea cambiar de mesa?','cambiar_mesa','Si','No')" id="btn-cambiar_mesa"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="transferir_pedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transferir Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                     <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-form-label">Elegir Mesa</label>
                        <select class="form-control" id="id_mesa_pn" name="id_mesa_pn">
                            <option value="">Seleccionar Mesa</option>
                            <?php
                            foreach ($mesas_pn as $m){
                                ?>
                                <option value="<?php echo $m->id_mesa;?>"><?php echo $m->mesa_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="preguntar('¿Está seguro que desea cambiar de mesa?','transferir_pedido','Si','No')" id="btn-cambiar_mesa"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cambiar_pedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 35% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transferir Pedido por Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="hidden" id="id_comanda_detalle_transferir" name="id_comanda_detalle_transferir">
                                <label class="col-form-label">Elegir Mesa</label>
                                <select class="form-control" id="id_mesa_transp" name="id_mesa_transp">
                                    <option value="">Seleccionar Mesa</option>
                                    <?php
                                    foreach ($mesas_pn as $m){
                                        ?>
                                        <option value="<?php echo $m->id_mesa;?>"><?php echo $m->mesa_nombre;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="preguntar('¿Está seguro que desea mover este pedido?','transferir_mesa_x_pedido','Si','No')" id="btn-cambiar_mesa_pedido"><i class="fa fa-save fa-sm text-white-50"></i> Transferir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="hidden" id="id_comanda_detalle_eliminar" name="id_comanda_detalle_eliminar">
                                <input type="hidden" id="id_comanda_eliminar" name="id_comanda_eliminar">
                                <input type="hidden" id="id_mesa_eliminar" name="id_mesa_eliminar">
                                <label class="col-form-label">Motivo</label>
                                <textarea class="form-control" name="comanda_detalle_eliminacion" id="comanda_detalle_eliminacion" cols="30" rows="2" placeholder="Ingrese Motivo..."></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Contraseña</label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="preguntar('¿Está seguro que desea eliminar este pedido?','eliminar_comanda_detalle','Si','No')" id="btn-cambiar_mesa"><i class="fa fa-save fa-sm text-white-50"></i> Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ventas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="persona">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label>Productos : </label><br>
                                    <!--<input type="checkbox" name="checkbox_todo" id="checkbox_todo" value="1" onchange="checkbox_todo()">
                                    <label for="checkbox_todo"> SELECCIONAR TODO</label>-->
                                    <hr>
                                    <div class="row" id="div_checkbox">
                                        <?php
                                        $cal_posi = 0;
                                        $cal_nega = 0;
                                        foreach($pedidos as $ls){

                                            $consultar_estado = $this->pedido->consultar($ls->id_comanda_detalle);
                                            if($ls->comanda_detalle_estado_venta == 0 || empty($consultar_estado)){
                                                //$tipo_afectacion = $this->pedido->tipo_afectacion_x_producto
                                                ?>
                                                <div class="col-md-12" style="font-weight: bold;">
                                                    <input  type="checkbox" onchange="calcular_total(<?= $ls->id_comanda_detalle;?>)" id="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>" name="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>" value="<?= $ls->id_comanda_detalle;?>" class="chk-box cobrar_venta_check">
                                                    <label for="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>"> <?php echo $ls->producto_nombre;?> // S/.<?php echo $ls->comanda_detalle_precio;?> // Cant. <?php echo $ls->comanda_detalle_cantidad?> // Total: <?php echo $ls->comanda_detalle_total;?> // Para: <?php echo $ls->comanda_detalle_despacho;?></label>
                                                    <input type="hidden" id="precio_total_detalle<?= $ls->id_comanda_detalle;?>" name="precio_total_detalle<?= $ls->id_comanda_detalle;?>" value="<?= $ls->comanda_detalle_total;?>">
                                                    <input type="hidden" id="tipo_afectacion_producto<?= $ls->id_comanda_detalle;?>" name="tipo_afectacion_producto<?= $ls->id_comanda_detalle;?>" value="<?= $ls->producto_precio_codigoafectacion;?>">
                                                    <input type="hidden" id="producto_precio_venta<?= $ls->id_comanda_detalle;?>" name="producto_precio_venta<?= $ls->id_comanda_detalle;?>" value="<?= $ls->comanda_detalle_precio;?>">
                                                    <input type="hidden" id="comanda_detalle_cantidad<?= $ls->id_comanda_detalle;?>" name="comanda_detalle_cantidad<?= $ls->id_comanda_detalle;?>" value="<?= $ls->comanda_detalle_cantidad;?>">
                                                    <input type="hidden" id="id_receta<?= $ls->id_comanda_detalle;?>" name="id_receta<?= $ls->id_comanda_detalle;?>" value="<?= $ls->id_receta;?>">
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="col-md-12" style="color: lightgray">
                                                    <input type="checkbox" disabled  id="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>">
                                                    <label for="id_comanda_detalle_<?= $ls->id_comanda_detalle;?>"> <?php echo $ls->producto_nombre;?> // S/.<?php echo $ls->comanda_detalle_precio;?> // Cant. <?php echo $ls->comanda_detalle_cantidad?> // Total: <?php echo $ls->comanda_detalle_total;?> // Para: <?php echo $ls->comanda_detalle_despacho;?></label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <hr>
                                    <!--<div class="row" >
                                        <div class="col-md-12" style="font-weight: bold;">
                                            <input  type="checkbox" id="por_consumo" name="por_consumo" onchange="obtener_total()" value="-1" class="chk-box_1">
                                            <label for="por_consumo">POR CONSUMO // S/. <span id="por_consumo_precio">0.00</span> // Cant. 1 // Total: <span id="por_consumo_total">0.00</span></label>
                                            <input type="hidden" id="por_consumo_precio_valor">
                                            <input type="hidden" id="por_consumo_total_valor">
                                            <input type="hidden" id="por_consumo_cantidad_valor" value="1">
                                        </div>
                                    </div>
                                    <hr>-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-8" style="text-align: right">
                                                    <label for="">DESCUENTO %</label><br>
                                                    <label for="" style="font-size: 14px;">OP. GRAVADAS</label><br>
                                                    <label for="" style="font-size: 14px;">IGV(18%)</label><br>
                                                    <label for="" style="font-size: 14px;">OP. EXONERADAS</label><br>
                                                    <label for="" style="font-size: 14px;">OP. INAFECTAS</label><br>
                                                    <label for="" style="font-size: 14px;">OP. GRATUITAS</label><br>
                                                    <label for="" style="font-size: 14px;">ICBPER</label><br>
                                                    <label for="" style="font-size: 17px;"><strong>TOTAL</strong></label><br>
                                                    <label for="" style="font-size: 14px;">VUELTO</label><br>
                                                    <label for="">DESCUENTO TOTAL</label>
                                                </div>
                                                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-2" style="text-align: right">
                                                    <label for=""><input style="border: 1px solid black;width: 70%" id="descuento_fizca" type="text" onkeyup="validar_numeros_decimales_dos(this.id);calcular_descuento_fizca(this.value)"></label>
                                                    <input type="hidden" id="descuento_f" name="descuento_f">
                                                    <label for="" style="font-size: 14px;"><span id="op_gravadas">0.00</span></label><br>
                                                    <input type="hidden" id="op_gravadas_" name="op_gravadas_">
                                                    <input type="hidden" id="op_gravadas__" name="op_gravadas__">
                                                    <label for="" style="font-size: 14px;"><span id="igv">0.00</span></label><br>
                                                    <input type="hidden" id="igv_" name="igv_">
                                                    <input type="hidden" id="igv__" name="igv__">
                                                    <label for="" style="font-size: 14px;"><span id="op_exoneradas">0.00</span></label><br>
                                                    <input type="hidden" id="op_exoneradas_" name="op_exoneradas_">
                                                    <input type="hidden" id="op_exoneradas__" name="op_exoneradas__">
                                                    <label for="" style="font-size: 14px;"><span id="op_inafectas">0.00</span></label><br>
                                                    <input type="hidden" id="op_inafectas_" name="op_inafectas_">
                                                    <input type="hidden" id="op_inafectas__" name="op_inafectas__">
                                                    <label for="" style="font-size: 14px;"><span id="op_gratuitas">0.00</span></label><br>
                                                    <input type="hidden" id="op_gratuitas_" name="op_gratuitas_">
                                                    <input type="hidden" id="op_gratuitas__" name="op_gratuitas__">
                                                    <label for="" style="font-size: 14px;"><span id="icbper">0.00</span></label><br>
                                                    <input type="hidden" id="icbper_" name="icbper_">
                                                    <input type="hidden" id="icbper__" name="icbper__">
                                                    <label for="" style="font-size: 17px;"><span id="venta_total">0.00</span></label><br>
                                                    <input type="hidden" id="venta_total_" name="venta_total_">
                                                    <input type="hidden" id="venta_total__" name="venta_total__">
                                                    <label for="" style="font-size: 14px;"><span id="vuelto">0.00</span></label><br>
                                                    <input type="hidden" id="vuelto_" name="vuelto_">
                                                    <label for=""><span id="des_global">0.00</span></label>
                                                    <input type="hidden" id="des_global_" name="des_global_">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="col-form-label">Partir Pago</label>
                                        <select class="form-control" id="partir_pago" name="partir_pago" onchange="partir_pago()">
                                            <option value="1">SI</option>
                                            <option value="2" selected>NO</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="col-form-label">Tipo de Pago</label>
                                        <select class="form-control" id="id_tipo_pago" name="id_tipo_pago">
                                            <?php
                                            foreach ($tipo_pago as $tp){
                                                ?>
                                                <option <?php echo ($tp->id_tipo_pago == 3) ? 'selected' : '';?> value="<?php echo $tp->id_tipo_pago;?>"><?php echo $tp->tipo_pago_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4" id="div_monto_1">
                                        <label class="col-form-label">Monto 1</label>
                                        <input type="text" class="form-control" id="monto_1" onblur="monto_dividido(this.value)">
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4" id="div_tipo_pago_2">
                                        <label class="col-form-label">Tipo de Pago 2</label>
                                        <select class="form-control" id="id_tipo_pago_2" name="id_tipo_pago_2">
                                            <?php
                                            foreach ($tipo_pago as $tp){
                                                ?>
                                                <option <?php echo ($tp->id_tipo_pago == 3) ? 'selected' : '';?> value="<?php echo $tp->id_tipo_pago;?>"><?php echo $tp->tipo_pago_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-4" id="div_monto_2">
                                        <label class="col-form-label">Monto 2</label>
                                        <input type="text" class="form-control" id="monto_2" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="tipo_igv">Tipo Venta</label><br>
                                            <select class="form-control" id="tipo_venta" name="tipo_venta" onchange="Consultar_serie()">
                                                <!--<option value="">Seleccionar...</option>-->
                                                <?php
                                                $consultar_existe_nota_venta = $this->pedido->consultar_existe_en_nota_venta_detalle($dato_pedido->id_comanda);
                                                (count($consultar_existe_nota_venta) != count($pedidos))?$en=true:$en=false;
                                                if($en){
                                                    ?>
                                                    <option value="20">Nota de Venta</option>
                                                    <?php
                                                }
                                                ?>
                                                <option value="03" selected>BOLETA</option>
                                                <option value="01">FACTURA</option>
                                                <!--<option value= "07">NOTA DE CREDITO</option>
                                                <option value= "08">NOTA DE DEBITO</option>-->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-6 col-ms-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="serie">Serie</label><br>
                                            <select class="form-control" id="serie" name="serie" onchange="ConsultarCorrelativo()" disabled>
                                                <option value="">Seleccionar...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-ms-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="correlativo">Correlativo</label><br>
                                            <input type="text" class="form-control" id="correlativo" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Pagó con:</label><br>
                                        <input type="text" class="form-control" name="pago_cliente" id="pago_cliente" onkeypress="return validar_numeros_decimales_dos(this.id)" onkeyup="calcular_vuelto()" >
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="tipo_moneda">Moneda</label><br>
                                            <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                                                <option value="1">SOLES</option>
                                                <option value="2">DOLARES</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="imprimir">¿Imprimir?</label><br>
                                            <select class="form-control" id="imprimir" name="imprimir">
                                                <option value="1">SI</option>
                                                <option value="2">NO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="gratis">Cortesía</label><br>
                                            <select class="form-control" onchange="select_cortesia()" id="gratis" name="gratis">
                                                <option value="1">SI</option>
                                                <option value="2" selected>NO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <label>Tipo Documento</label><br>
                                        <select  class="form-control" name="select_tipodocumento" id="select_tipodocumento" onchange="seleccionar_tipodocumento()">
                                            <option value="">Seleccionar...</option>
                                            <?php
                                            foreach ($tipos_documento as $td){
                                                ($td->id_tipodocumento==2)?$sele='selected':$sele='';
                                                echo "<option value='".$td->id_tipodocumento."' $sele >".$td->tipodocumento_identidad."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-5" id="div_observacion_cortesia">
                                        <label>Observación de Cortesía</label><br>
                                        <textarea class="form-control" name="observacion_cortesia" id="observacion_cortesia" cols="30" rows="2"></textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">DNI / RUC </label><br>
                                                    <input type="text" class="form-control" id="cliente_numero" value="11111111" onchange="consultar_documento(this.value)" onkeyup="return validar_numeros(this.id)">
                                                    <!--<label for="" id="cliente_numero"></label>-->
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label for="">Cliente</label><br>
                                                    <textarea rows="2" class="form-control" type="text" id="cliente_nombre" name="cliente_nombre" maxlength="500" placeholder="Ingrese Razón Social...">ANONIMO</textarea>

                                                    <!--<label for="" id="cliente_nombre"></label>-->
                                                    <input type="hidden" id="id_cliente">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="">Dirección</label><br>
                                                    <textarea rows="2" class="form-control" type="text" id="cliente_direccion" name="cliente_direccion" maxlength="500" placeholder="Ingrese Dirección..."></textarea>
                                                    <!--<label for="" id="cliente_direccion"></label>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="form-group col-lg-9">
                                        <input required autocomplete="off" name="parametro_c" onkeyup="buscar_cliente()" type="text" class="form-control" id="parametro_c" placeholder="Buscar Cliente">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <button class="btn btn-success" style="width: 60%"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="cliente" class="table-responsive">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="form-group col-lg-12" style="text-align: right;">
                                        <input type="hidden" id="datos_detalle_pedido" name="datos_detalle_pedido">
                                        <input type="hidden" id="id_mesa" name="id_mesa" value="<?= $id;?>">
                                        <button type="button" onclick="agregar()" class="btn btn-danger" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" onclick="agregar()" class="btn btn-success" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cantidad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="persona">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Cantidad de Personas</label>
                                <input type="number" class="form-control" id="comanda_cantidad_personas" name="comanda_cantidad_personas" value="<?= $dato->comanda_cantidad_personas;?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="cambiar_cantidad()" class="btn btn-success" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pre_cuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 60% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Imprimir Pre Cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="" enctype="multipart/form-data" id="imprimir_pre_cuenta">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead class="text-capitalize">
                                                    <tr>
                                                        <th><i class="fa fa-print"></i></th>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio Unitario</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $det = 0;
                                                    $det_cero = 0;
                                                    $a = 1;
                                                    foreach ($pedidos_pre_cuenta as $p){
                                                        $pre_uni = $p->comanda_detalle_precio;
                                                        if ($p->id_receta == "131"){
                                                            $pre_uni = $p->comanda_detalle_precio + $icbper;
                                                        }
                                                        $total += $p->comanda_detalle_cantidad * $pre_uni;
                                                        $subtotal = $p->comanda_detalle_cantidad * $pre_uni;
                                                        ?>
                                                        <tr id="detalle<?= $p->id_comanda_detalle;?>" <?= $estilo;?>>
                                                            <td style="text-align: center"><input checked name='imprimir_detalle[]' type='checkbox' id='imprimir_detalle[]' class='chk-box' value='<?= $p->id_comanda_detalle;?>'></td>
                                                            <td style="font-size: 13px;">
                                                                <p><?php echo $p->producto_nombre;?> // S/.<?php echo $p->comanda_detalle_precio;?> // Cant. <?php echo $p->comanda_detalle_cantidad?> // Total: <?php echo $p->comanda_detalle_total;?> // Para: <?php echo $p->comanda_detalle_despacho;?> // Oservación: <?= $p->comanda_detalle_observacion;?>
                                                                </p>
                                                            </td>
                                                            <td><?= $p->comanda_detalle_cantidad;?></td>
                                                            <td><?= $pre_uni;?></td>
                                                            <td><?= $subtotal;?></td>
                                                        </tr>
                                                        <?php
                                                        $a++;
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12" style="text-align: center">
                        <input type="hidden" id="comanda_ultimo" name="comanda_ultimo" value="<?= $ultimo_valor_;?>">
                        <button type="submit" class="btn btn-success" id="btn-print-precuenta"> <i class="fa fa-print"></i> Imprimir</button>
                        <button type="button" class="btn btn-secondary" onclick="" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>
            <div class="row">
                <div class="col-lg-2 col-xs-2 col-md-2 col-sm-2">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#cambiar_mesa"><i class="fa fa-retweet"></i> Cambiar Mesa</button>
                </div>
                <div class="col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col-lg-2 col-xs-2 col-md-2 col-sm-2">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#transferir_pedido"><i class="fa fa-refresh"></i> Transferir</button>
                </div>
                <div class="col-sm-1 col-md-1 col-xs-1" style="display: none"></div>
                <div class="col-lg-2 col-xs-2 col-md-2 col-sm-2" style="display: none">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#cantidad"><i class="fa fa-save"></i> Cant. Personas</button>
                </div>
                <div class="col-sm-1 col-md-1 col-xs-1"></div>
                <div class="col-lg-2 col-xs-2 col-md-2 col-sm-2">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#agregar_pedido_nuevo"><i class="fa fa-pencil"></i> Nuevo Pedido</button>
                </div>
             </div>
            <br>
            <div class="row">
                <div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h3><b>Pedido # <?= $dato_pedido->comanda_correlativo;?></b> // <?= $dato_pedido->mesa_nombre;?> // Personas: <?= $dato_pedido->comanda_cantidad_personas;?></h3></div>
                <div class="col-lg-12" style="text-align: center"><h3><?= date('d-m-Y H:i:s',strtotime($dato_pedido->comanda_fecha_registro))?></h3></div>
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12" style="text-align: center;">
                                                <h4>TOTAL DEL PEDIDO s/. <span style="color: black; font-size: 20pt;"><?= $dato_pedido->comanda_total; ?></span></h4>
                                                <h5>Falta cancelar s/. <span id="total_por_cancelar" style="color: red; font-size: 15pt;"></span></h5>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>Mesero</th>
                                        <th>Producto</th>
                                        <th>Observación</th>
                                        <!--<th>N° Pedido</th>-->
                                        <th>Precio Unitario</th>
                                        <th style="width: 65px;">Cantidad</th>
                                        <th>Total</th>
                                        <th>Fecha / Hora</th>
                                        <th>Acción</th>
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $det = 0;
                                    $det_cero = 0;
                                    $total_x_cancelar = 0;
                                    $a = 1;
                                    foreach ($pedidos as $p){
                                        $estilo = "";
                                        if($p->comanda_detalle_estado_venta == "0"){
                                            $estilo = "style=\"background-color: #ea817c\"";
                                            $total_x_cancelar = $total_x_cancelar + $p->comanda_detalle_total;
                                        }
                                        ?>
                                        <tr id="detalle<?= $p->id_comanda_detalle;?>" <?= $estilo;?>>
                                            <td><?= $p->persona_nombre;?></td>
                                            <td><?= $p->producto_nombre;?></td>
                                            <td><?= $p->comanda_detalle_observacion?></td>
                                            <!--<td><?= $p->comanda_correlativo;?></td>-->
                                            <input type="hidden" id="comanda_detalle_precio<?= $p->id_comanda_detalle;?>" value="<?= $p->comanda_detalle_precio;?>">
                                            <td><?= $p->comanda_detalle_precio;?></td>
                                            <?php
                                            if($p->comanda_detalle_estado_venta == "0" && ($id_rol==2 || $id_rol==3)){ ?>
                                                <td><input class="form-control" type="number" id="cantidad_detalle_cantidad<?= $p->id_comanda_detalle;?>" value="<?= $p->comanda_detalle_cantidad;?>" onchange="cambiar_comanda_detalle_cantidad(<?= $p->id_comanda_detalle;?>, <?= $p->id_comanda;?>)"></td>
                                            <?php
                                            }else{ ?>
                                            <td><?= $p->comanda_detalle_cantidad;?></td>
                                            <?php
                                            }
                                            ?>
                                            <td><span id="span_comanda_detalle_total<?= $p->id_comanda_detalle;?>"><?= $p->comanda_detalle_total;?></span></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($p->comanda_detalle_fecha_registro));?>
                                            <td>
                                                <?php
                                                if($p->comanda_detalle_estado_venta == 0){
                                                ?>
                                                <a class="btn btn-danger" type="button" id="btn-eliminar_pedido" onclick="cargar_valores(<?= $p->id_comanda_detalle;?>,'<?= $p->id_comanda?>','<?= $p->id_mesa?>')" data-toggle="modal" data-target="#eliminar" title='Eliminar'><i class='fa fa-times text-white eliminar margen'></i></a>
                                                <a class="btn btn-primary" type="button" id="btn-cambiar_pedido" onclick="cargar_transferencia(<?= $p->id_comanda_detalle;?>)" data-toggle="modal" data-target="#cambiar_pedido" title='Transferir'><i class='fa fa-refresh text-white eliminar margen'></i></a>
                                                    <?php
                                                }
                                                else{
                                                ?>
                                                   <!-- <a class="btn btn-danger" type="button" id="btn-eliminar_servicio" onclick="preguntar('¿El pedido no se puede eliminar porque ya esta siendo preparado?','eliminar_comanda_detalle','Si','No',<?= $p->id_comanda_detalle;?>)" data-toggle="tooltip" title='No se Puede Eliminar'><i class='fa fa-eyes text-white eliminar margen'></i></a> -->
                                                <?php
                                                }
                                                ?>
                                            </td>

                                            <?php
                                            $consultar_estado = $this->pedido->consultar($p->id_comanda_detalle);
                                            (!empty($consultar_estado))?$det++:$det_cero++;
                                            ($p->comanda_detalle_estado_venta == 1)?$resultado=true:$resultado=false;
                                            if($resultado){
                                                ?>
                                                <td>PAGADO</td>
                                            <?php
                                            }else{
                                                ?>
                                                <td>Pendiente de Pago</td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-3 col-sm-3 col-md-3" style="display: none">
                                    <a id="imprimir_ticket_comanda" style="color: white;" class="btn btn-warning" onclick="ticket_comanda_pedido(<?= $ultimo_valor_; ?>)"><i class="fa fa-print"></i> Comanda</a>
                                </div>
                                <?php
                                $entre=true;
                                $fecha = date('Y-m-d');
                                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                                $caja_apertura_fecha = $this->pedido->listar_ultima_fecha($id_usuario);

                                if($id_rol == 2 || $id_rol == 3 || $id_rol ==5){
                                    ?>

                                    <div class="col-lg-3 col-sm-3 col-md-3">
                                        <a id="imprimir_ticket" style="color: white;" class="btn btn-success"><i class="fa fa-print"></i> Pre Cuenta</a>
                                    </div>
                                    <?php
                                    if($caja_apertura_fecha){
                                        ?>
                                        <div class="col-lg-3 col-sm-3 col-md-3">
                                            <button type="button" id="btn_generarventa" class="btn btn-primary" data-toggle="modal" data-target="#ventas">
                                                <i class="fa fa-money"></i> Cobrar</button>
                                        </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="col-lg-3 col-sm-3 col-md-3">
                                        <button type="button" id="btn_generarventa" class="btn btn-primary" data-toggle="modal" onclick="preguntar('Usted no aperturo caja, ¿Desea ir al inicio para aperturar?','ir_caja','SÍ','NO')">
                                            <i class="fa fa-money"></i> Cobrar</button>
                                    </div>
                                <?php
                                    }
                                }
                                ?>
                                <div class="col-lg-3 col-sm-3 col-md-3" style="text-align: right">
                                    <a class="btn btn-secondary" href="<?= _SERVER_?>Pedido/gestionar" role="button"><i class="fa fa-backward"></i> Regresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>pedido.js"></script>

<script>
    $(document).ready(function (){
        $("#mostrar").hide();
        Consultar_serie();
        var por_cancelar_ = <?= $total_x_cancelar;?>;
        var por_cancelar = por_cancelar_.toFixed(2);
        $("#total_por_cancelar").html(por_cancelar);
        partir_pago();
        select_cortesia();

        $('#parametro').keypress(function(e){
            if(e.which === 13){
                productos_nuevo();
            }
        });
        checkbox_todo();
    });

    $('#imprimir_ticket').on('click',function(){
        $('#pre_cuenta').modal({backdrop: 'static', keyboard: false})
    })

    $("#imprimir_pre_cuenta").on('submit', function(e){
        e.preventDefault();
        var valor = true;
        var boton = 'btn-print-precuenta';

        if (valor){
            $.ajax({
                type:"POST",
                url: urlweb + "api/Pedido/ticket_pedido",
                dataType: 'json',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function () {
                    cambiar_estado_boton(boton, 'imprimiendo...', true);
                },
                success:function (r) {
                    cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Imprimir", false);
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Éxito!...', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 200);
                            break;
                        default:
                            respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                            break;
                    }
                }
            });
        }
    });

    var contenido_pedido = "";

    function ir_caja(){
        location.href = urlweb +  'Admin/inicio';
    }

    function cargar_valores(id_comanda_detalle,id_comanda,id_mesa){
        $("#id_comanda_detalle_eliminar").val(id_comanda_detalle);
        $("#id_comanda_eliminar").val(id_comanda);
        $("#id_mesa_eliminar").val(id_mesa);
    }

    function cargar_transferencia(id_comanda_detalle){
        $("#id_comanda_detalle_transferir").val(id_comanda_detalle);
    }

    function ticket_pedido(id){
        var boton = 'imprimir_ticket';
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/ticket_pedido",
            data: "id=" + id,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'imprimiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Pre Cuenta", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Éxito!...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 800);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
    function ticket_comanda_pedido(id_comanda){
        var boton = 'imprimir_ticket_comanda';
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/ticket_comanda",
            data: "id=" + id_comanda,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'imprimiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Comanda", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Éxito!...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 800);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
    function consultar_documento(valor){
        var tipo_doc = $('#select_tipodocumento').val();
        $.ajax({
            type: "POST",
            url: urlweb + "api/Clientes/obtener_datos_x_dni",
            data: "numero="+valor,
            dataType: 'json',
            success:function (r) {
                if(r.result.resultado == 1){
                    $("#cliente_nombre").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
                    $("#cliente_direccion").val(r.result.direccion);
                }else{
                    if(tipo_doc == "2"){
                        ObtenerDatosDni(valor);
                    }else if(tipo_doc == "4"){
                        if(valor.length == 11){
                            ObtenerDatosRuc(valor)
                        }else{
                            respuesta('¡El RUC tiene que teer 11 dígitos!', 'error');
                            $("#cliente_nombre").val('');
                            $("#cliente_direccion").val('');
                        }
                    }
                }
            }
        });
    }

    function ObtenerDatosDni(valor){
        var numero_dni =  valor;

        //cambiar_estado_boton('cliente_nombre', 'buscando...', true);
        var formData = new FormData();
        formData.append("token", "WNxcDmZ1Nftc1QeJcSHpDgdaW5ynN9gL8t2VQvjAQGBYt4HcUlPzxvf03c4c");
        formData.append("dni", numero_dni);
        var request = new XMLHttpRequest();
        request.open("POST", "https://api.migo.pe/api/v1/dni");
        request.setRequestHeader("Accept", "application/json");
        request.send(formData);
        //$('.loader').show();
        request.onload = function() {
            var data = JSON.parse(this.response);
            if(data.success){
                //$('.loader').hide();
                console.log("Datos Encontrados");
                cambiar_estado_boton('cliente_nombre', "", false);
                //$('#cotizacion_beneficiario').val(data.nombre);
                $("#cliente_nombre").val(data.nombre);
                //$('#cliente_direccion').val('');
                //$('#cliente_condicion').val("HABIDO");
            }else{
                //$('.loader').hide();
                console.log(data.message);
            }
        };
    }
    function ObtenerDatosRuc(valor){
        var numero_ruc =  valor;

        //cambiar_estado_boton('cliente_nombre', 'buscando...', true);
        //cambiar_estado_boton('cliente_direccion', 'buscando...', true);
        var formData = new FormData();
        formData.append("token", "WNxcDmZ1Nftc1QeJcSHpDgdaW5ynN9gL8t2VQvjAQGBYt4HcUlPzxvf03c4c");
        formData.append("ruc", numero_ruc);
        var request = new XMLHttpRequest();
        request.open("POST", "https://api.migo.pe/api/v1/ruc");
        request.setRequestHeader("Accept", "application/json");
        request.send(formData);
        $('.loader').show();
        request.onload = function() {
            var data = JSON.parse(this.response);
            if(data.success){
                //$('.loader').hide();
                console.log("Datos Encontrados");
                cambiar_estado_boton('cliente_nombre', "", false);
                cambiar_estado_boton('cliente_direccion', "", false);
                //$('#cotizacion_beneficiario').val(data.nombre_o_razon_social);
                $("#cliente_nombre").val(data.nombre_o_razon_social);
                $("#cliente_direccion").val(data.direccion);
            }else{
                //$('.loader').hide();
                console.log(data.message);
            }
        };
        /*$.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#client_name").val(r.result.razon_social);
            }
        });*/
    }
    //INICIO - AGREGAR NUEVOS PEDIDOS
    function add_pedido_nuevo(){
        var comanda_detalle_observacion = $("#comanda_detalle_observacion").val();
        var producto_nombre = $("#producto_nombre").val();
        var id_producto = $("#id_producto").val();
        var comanda_detalle_cantidad = $("#comanda_detalle_cantidad").val() * 1;
        var comanda_detalle_precio = $("#comanda_detalle_precio").val() * 1;
        var comanda_detalle_despacho = $("#comanda_detalle_despacho").val();


        var subtotal = comanda_detalle_cantidad * comanda_detalle_precio;
        subtotal.toFixed(2);
        subtotal = subtotal.toFixed(2);

        /*total_total = total_total + subtotal;
        total_total.toFixed(2);
        total_total = parseFloat(total_total);*/

        if(id_producto !="" && comanda_detalle_cantidad!="" && comanda_detalle_precio!="" && producto_nombre!="" && subtotal!="" && comanda_detalle_despacho !="" ){
            contenido_pedido += id_producto + "-.-." + producto_nombre + "-.-."+ comanda_detalle_precio+"-.-." + comanda_detalle_cantidad +"-.-."+comanda_detalle_despacho+"-.-." + comanda_detalle_observacion+"-.-."+subtotal+"/./.";
            $("#contenido_pedido").val(contenido_pedido);
            //$("#comanda_total_pedido").val(subtotal);
            show_table();
            clean();
        }else{
            respuesta('Ingrese todos los campos');
        }
    }
    function show_table() {
        var llenar="";
        conteo=1;
        var monto_total = 0;
        var total = 0.00;
        if (contenido_pedido.length>0){
            var filas=contenido_pedido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    var celdas =filas[i].split('-.-.');
                    llenar +="<tr>" +
                        "<td>"+celdas[1]+"</td>"+
                        "<td>"+celdas[2]+"</td>"+
                        "<td>"+celdas[3]+"</td>"+
                        "<td>"+celdas[4]+"</td>"+
                        "<td>"+celdas[5]+"</td>"+
                        "<td>"+celdas[6]+"</td>"+
                        "<td><a data-toggle=\"tooltip\" onclick='delete_detalle("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                        "</tr>";
                    conteo++;
                    monto_total = monto_total + celdas[6] * 1;
                    total = monto_total.toFixed(2);
                }
            }
        }
        $("#contenido_detalle_compra").html(llenar);
        $("#conteo").html(conteo);
        $("#comanda_total").val(total);
        $("#comanda_total_").html("S/ " + total);
        //$("#contenido_pedido").val(contenido_pedido);
    }
    function delete_detalle(ind) {
        var contenido_artificio ="";
        if (contenido_pedido.length>0){
            var filas=contenido_pedido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    if(i!=ind){
                        var celdas =filas[i].split('-.-.');
                        contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-." +celdas[4] + "-.-."+ celdas[5] + "-.-."+ celdas[6] + "/./.";
                    }else{
                        var celdas =filas[i].split('-.-.');
                    }
                }
            }
        }
        contenido_pedido = contenido_artificio;
        show_table();
    }
    function clean() {
        $("#comanda_detalle_observacion").val("-");
        $("#producto_nombre").val("");
        $("#id_producto").val("");
        $("#comanda_detalle_cantidad").val("1");

        $("#comanda_detalle_despacho option[value='salon']").attr('selected','selected');
        $("#comanda_detalle_precio").val("");
        $("#producto_nombre_").html("");
        $("#comanda_detalle_precio_").html("");
        $("#parametro").val("");
    }
    //FIN - AGREGAR NUEVOS PEDIDOS
    function partir_pago(){
        var partir = $('#partir_pago').val();
        if(partir == 1){
            $('#div_monto_1').show();
            $('#div_tipo_pago_2').show();
            $('#div_monto_2').show();
        }else {
            $('#div_monto_1').hide();
            $('#monto_1').val('');
            $('#monto_2').val('');
            $('#div_tipo_pago_2').hide();
            $('#div_monto_2').hide();
        }

    }
    function monto_dividido(valor){
        var total = $('#venta_total_').val() * 1;
        if(valor <= total){
            var resta = total - valor * 1;
            $('#monto_2').val(resta.toFixed(2));
        }else{
            respuesta('Monto ' + valor + ' tiene que ser menor que ' + total);
            $('#monto_2').val('');

        }
    }
    function select_cortesia(){
        var  cortesia = $('#gratis').val();
        if(cortesia == 1){
            $('#div_observacion_cortesia').show();
        }else{
            $('#div_observacion_cortesia').hide();
        }
    }
    function checkbox_todo(){
        $('.chk-box').attr('checked', "checked");
        /*var che_todo = $('#checkbox_todo');
        if (che_todo.is(':checked')){
            $('.chk-box').attr('checked', "checked");
            //$('#div_checkbox > input[type=checkbox]').prop('checked', $(this).is(':checked'));
        }else{
            $(".chk-box:checkbox:checked").removeAttr("checked");
        }*/

        <?php
        foreach($pedidos as $ls){
            ?>
            var id = "<?= $ls->id_comanda_detalle;?>";
            calcular_total(id)
            <?php
        }
        ?>
    }

    //FUNCIONES PARA EL DESCUENTO
    function calcular_descuento_fizca(valor){
        if(valor >= 99.9){
            $("#contrita").show();
        }else{
            $("#contrita").hide();

        }
        if(valor > 99.90){
            valor = 99.90;
            $("#descuento_fizca").val(valor);
            $("#descuento_f").val(valor);
        }

        var desc_porcentaje = valor / 100 * 1;
        var des_item_ = $('#des_item').val() * 1;
        var montototal = $('#venta_total__').val() * 1;

        var exonerada = $('#op_exoneradas__').val();
        var inafecta = $('#op_inafectas__').val();
        var gravada = $('#op_gravadas__').val();
        //var montototal = $('#montototal').val();
        var desc_total_ = montototal * desc_porcentaje;
        var desc_total = desc_total_.toFixed(2);

        $('#des_global_').val(desc_total);
        $('#des_global').html(desc_total);

        var total_descuento = desc_total_ + des_item_;
        $('#des_total_').html(total_descuento.toFixed(2));
        $('#des_total').val(total_descuento.toFixed(2));
        $('#descuento_global').val(desc_porcentaje);
        var total_exonerado = 0;
        var total_gravada = 0;
        var igv = 0;
        var total_ = 0;
        if(exonerada > 0){
            var desc_exonerado_ = exonerada * desc_porcentaje * 1;
            var desc_exonerado = exonerada - desc_exonerado_;
            total_exonerado = desc_exonerado.toFixed(2);
            $('#op_exoneradas').html(total_exonerado);
            $('#op_exoneradas_').val(total_exonerado);
        }
        if(gravada > 0){
            var desc_gravada_ = gravada * desc_porcentaje * 1;
            var desc_gravada = gravada - desc_gravada_;
            total_gravada = desc_gravada.toFixed(2);
            var igv_ = desc_gravada * 0.18 ;
            igv = igv_.toFixed(2) * 1;
            $('#op_gravadas_').html(total_gravada);
            $('#op_gravadas').val(total_gravada);
            $('#igv').html(igv);
            $('#igv_').val(igv);
        }
        var exo = $('#op_exoneradas_').val() * 1;
        var gra = $('#op_gravadas_').val() * 1;
        var ig = $('#igv_').val() * 1;
        total_ = (exo + gra + ig) * 1;
        var total = total_.toFixed(2);
        var total = total_.toFixed(2);
        $('#venta_total').html(total);
        $('#venta_total_').val(total);
    }


</script>