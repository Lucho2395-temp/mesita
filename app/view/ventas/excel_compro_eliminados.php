

<div class="row">

    <div class="col-lg-12">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="" width="100%" cellspacing="0" border="1">
                        <!--filtro para buscar alumno por nombre, apellido y dni-->

                        <h2 style="">HISTORIAL DE COMPROBANTES ELIMINADOS || FECHA : <strong><?= $fecha_vacio; ?></strong></h2>

                        <thead class="text-capitalize">
                        <br><br>
                        <tr style="background: deepskyblue;">
                            <th>#</th>
                            <th>FECHA DE CREACION</th>
                            <th>COMPROBANTE</th>
                            <th>SERIE</th>
                            <th>CORRELATIVO</th>
                            <th>CLIENTE</th>
                            <th>USUARIO</th>
                            <th>MONEDA</th>
                            <th>MOTIVO</th>
                            <th>FECHA ANULACION</th>
                            <th>USUARIO ELIMINACION</th>
                            <th>TOTAL</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $a = 1;
                        $total = 0;
                        //$total_eliminado = 0;
                        foreach ($ventas as $m){
                            $buscar_usuario = $this->ventas->buscar_usuario($m->venta_usuario_eli);
                            if($m->id_tipodocumento == 4){
                                $cliente = $m->cliente_razonsocial;
                            }else{
                                $cliente = $m->cliente_nombre;
                            }
                            //CALCULO
                            if($m->venta_tipo == "03"){
                                $venta_tipo = "BOLETA";
                                if($m->anulado_sunat == 1){
                                    $total = round($total + $m->venta_total, 2);
                                }
                            }elseif ($m->venta_tipo == "01"){
                                $venta_tipo = "FACTURA";
                                if($m->anulado_sunat == 1){
                                    $total = round($total + $m->venta_total, 2);
                                }
                            }elseif ($m->venta_tipo == "20"){
                                $venta_tipo = "NOTA DE VENTA";
                                if($m->anulado_sunat == 1){
                                    $total = round($total + $m->venta_total, 2);
                                }
                            }elseif($m->venta_tipo == "07"){
                                $venta_tipo = "NOTA DE CRÉDITO";
                            }elseif($m->venta_tipo == "08"){
                                $venta_tipo= "NOTA DE DÉBITO";
                                if($m->anulado_sunat == 1){
                                    $total = round($total + $m->venta_total, 2);
                                }
                            }else{
                                $venta_tipo = "TODOS";
                            }

                            $nombre_usuario = $m->persona_nombre. ' ' .$m->persona_apellido_paterno. ' ' .$m->persona_apellido_materno;
                            ?>
                            <tr>
                                <td style="text-align: center"><?= $a;?></td>
                                <td style="text-align: center"><?= date('d-m-Y h:i:s', strtotime($m->venta_fecha));?></td>
                                <td style="text-align: center"><?= utf8_decode($venta_tipo);?></td>
                                <td style="text-align: center"><?= $m->venta_serie;?></td>
                                <td style="text-align: center"><?= $m->venta_correlativo;?></td>
                                <td style="text-align: center"><?= utf8_decode($m->cliente_numero);?> <?= utf8_decode($cliente);?></td>
                                <td style="text-align: center"><?= utf8_decode($nombre_usuario);?></td>
                                <td style="text-align: center"><?= utf8_decode($m->abrstandar);?></td>
                                <td style="text-align: center"><?= utf8_decode($m->venta_motivo_eli)?></td>
                                <td style="text-align: center;"><?= date('d-m-Y H:i:s',strtotime($m->venta_fecha_eli))?></td>
                                <td style="text-align: center;"><?= utf8_decode($buscar_usuario->persona_nombre)?> <?= utf8_decode($buscar_usuario->persona_apellido_paterno)?></td>
                                <td style="text-align: center;"> S/. <?= number_format($m->venta_total,2);?></td>
                            </tr>

                            <?php
                            $a++;
                        }
                        ?>
                        </tbody>
                        <tfooter>
                            <tr>
                                <td></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">TOTAL:</td>
                                <td style="text-align: center;">S/. <?= number_format($total,2);?></td>
                            </tr>
                        </tfooter>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>