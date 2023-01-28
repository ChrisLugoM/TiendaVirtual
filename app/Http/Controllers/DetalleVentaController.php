<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Productos;
use App\Models\Venta;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\DB;

class DetalleVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Productos::all();
        $total = count($productos);
        //$productos = $product->toArray();
        return view('sistema.tienda.admin', compact('productos', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $producto = Productos::find($request->product_id);
        \Cart::add(array(
            'id' => $producto->id,
            'name' => $producto->nombre_prod,
            'price' => $producto->precio,
            'quantity' => $request->cantidad,
            'existencia' => $producto->existencia,
            'img' => $producto->nombre_img,
            'user' => $producto->usuario,
        ));
        return back()->with('success', "$producto->nombre se ha agregado");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetalleVenta  $detalleVenta
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // ver datos array $cartCollection = \Cart::getContent();
        return view('sistema.tienda.carrito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetalleVenta  $detalleVenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $prod = $request->id;
        $cant = $request->cantidad;
        \Cart::remove($prod);
        $producto = Productos::find($prod);
        \Cart::add(array(
            'id' => $producto->id,
            'name' => $producto->nombre_prod,
            'price' => $producto->precio,
            'quantity' => $cant,
            'existencia' => $producto->existencia,
            'img' => $producto->nombre_img,
            'user' => $producto->usuario,
        ));
        //return json_encode(\Cart::getContent());
        return view('sistema.tienda.carrito');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetalleVenta  $detalleVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetalleVenta $detalleVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetalleVenta  $detalleVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Productos::where('id', $id)->firstOrFail();
        \Cart::remove([
            'id' => $id,
        ]);
        return back()->with('success', "se ha eliminado");
    }
    public function pago()
    {
        // ver datos array $cartCollection = \Cart::getContent();
        $total_iva = number_format(\Cart::getSubtotal() * 0.16, 2);
        $total = number_format($total_iva + \Cart::getTotal(), 2);
        $total = preg_replace('([,])', '', $total);
        return view('sistema.tienda.paypal', compact('total'));
    }
    public function cancelacion(Request $request)
    {
        $venta = new Venta();
        $venta->OrdenID = $request->orden;
        $venta->estatus_venta = "Cancelado";
        $venta->user = auth()->user()->usuario;
        $venta->total_venta = $request->total;
        $venta->save();
        $venta_ultima = $venta->id;
        foreach (\Cart::getContent() as $rows) {
            $detalle_venta = new DetalleVenta();
            $detalle_venta->id_venta = $venta_ultima;
            $detalle_venta->id_producto = $rows->id;
            $detalle_venta->precio = $rows->price;
            $detalle_venta->cantidad = $rows->quantity;
            $detalle_venta->save();
        }
    }
    public function proceso_pago(Request $request)
    {
        $ClientID = "AQAgUcO4tuMp_riAhXNn3-p86jBIcrEMLNILkBnT56IBPBZDL5kd_c5Z8Ej8jdphr4IBgPMAehnPG0Cw";
        $Secret = "ELq7HAPNMjxmkc0EKK1rThClDzd99F4rGDlBhMCBsTKFXBOnI1XMJ4AjdbLRW-iHQ1f1OMGcSfF-loHK";
        $val = $request->OrderID;
        $url = "https://api-m.sandbox.paypal.com/v2/checkout/orders/" . $val;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        /*
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        */
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, $ClientID . ":" . $Secret);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);
        curl_close($curl);
        $resultado = json_decode($data);
        /* registro de venta */
        $venta = new Venta();
        $venta->OrdenID = $val;
        $venta->estatus_venta = $resultado->status;
        $venta->user = auth()->user()->usuario;
        $venta->total_venta = $resultado->purchase_units[0]->amount->value;
        $venta->save();
        /* registro de detalle de productos */
        $venta_ultima = $venta->id;
        foreach (\Cart::getContent() as $rows) {
            $detalle_venta = new DetalleVenta();
            $detalle_venta->id_venta = $venta_ultima;
            $detalle_venta->id_producto = $rows->id;
            $detalle_venta->precio = $rows->price;
            $detalle_venta->cantidad = $rows->quantity;
            $detalle_venta->save();
        }
        //destroy($venta_ultima);
        $valor = $resultado->status;
        \Cart::clear();
        return $valor;
    }
    public function show_listventas()
    {
        $name_user = auth()->user()->usuario;
        $ventas = DB::table('venta')->where('user', '=', $name_user)->get();
        return view('sistema.ventas_compras.admin', compact('ventas'));
    }
    public function detalle_venta($id_venta)
    {
        $detalle_venta = DB::table('detalleventa')->where('id_venta', '=', $id_venta)->get();
        $cantidad = DB::table('detalleventa')->where('id_venta', $id_venta)->count();
        //$producto = $detalle_venta->id_producto;
        //$productos = Productos::find($producto);
        $productos = [];
        for ($i = 0; $i < $cantidad; $i++) {
            $detalle_vent = DB::table('productos')->where('id', $detalle_venta[$i]->id_producto)->get();
            foreach ($detalle_vent as $value) {
                array_push($productos, $value);
            }
        }
        $suma_total = 0;
        foreach ($detalle_venta as $venta) {
            $suma_total += $venta->precio * $venta->cantidad;
        }
        return view('sistema.ventas_compras.detalles', compact('detalle_venta', 'productos', 'suma_total', 'id_venta'));
    }
    public function reporte_pdf($id_venta)
    {
        $detalle_venta = DB::table('detalleventa')->where('id_venta', '=', $id_venta)->get();
        $datos_venta = DB::table('venta')->where('id_venta', '=', $id_venta)->get();
        $usuario = $datos_venta[0]->user;
        $datos_comprador = DB::table('users')->where('usuario', '=', $usuario)->get();
        $fpdf = new Fpdf();
        $fpdf->AddPage();
        /* Titulo de la pagina */
        $fpdf->SetTitle($datos_venta[0]->OrdenID);
        $fpdf->SetFont('Times', 'B', 18);
        $fpdf->SetFillColor(162, 232, 250);
        $fpdf->Cell(190, 20, 'FORMATO DE COMPROBANTE DE COMPRAS', 0, 1, 'C', 1);
        /* Cabecera de la pagina */
        $fpdf->SetFont('Times', '', 10);
        $fpdf->SetFillColor(162, 174, 250);
        $fpdf->Cell(90, 10, 'EMPRESA SA DE CV', 0, 0, 'C', 1);
        $fpdf->SetFillColor(100, 185, 250);
        $fpdf->Cell(100, 10, 'Comprobante de Compra', 0, 0, 'C', 1);
        $fpdf->Ln(10);
        $fpdf->SetFillColor(162, 174, 250); //morado
        $fpdf->Cell(90, 10, 'Emitida por: ' . $datos_comprador[0]->name . ' ' . $datos_comprador[0]->last_name, 0, 0, 'C', 1);
        $fpdf->SetFillColor(100, 185, 250); //azul
        $fecha_emitida = $datos_venta[0]->created_at;
        $fecha_gen = $this->orden_fecha($fecha_emitida);
        $fpdf->Cell(100, 10, 'Fecha de Emision: ' . $fecha_gen, 0, 0, 'C', 1);
        $fpdf->Ln(10);
        $fpdf->SetFillColor(162, 174, 250); //morado
        $fpdf->Cell(90, 10, 'No. de Orden: ' . $datos_venta[0]->OrdenID, 0, 0, 'C', 1);
        $fpdf->SetFillColor(100, 185, 250); //azul
        $fpdf->Cell(100, 10, 'Estatus: ' . $datos_venta[0]->estatus_venta, 0, 0, 'C', 1);
        $fpdf->Ln(20);
        $fpdf->SetFillColor(139, 251, 212);
        $fpdf->Cell(20, 10, '');
        $fpdf->Cell(30, 10, 'Descripcion', 0, 0, 'C', 1);
        $fpdf->Cell(30, 10, 'Producto', 0, 0, 'C', 1);
        $fpdf->Cell(30, 10, 'Precio Unitario', 0, 0, 'C', 1);
        $fpdf->Cell(30, 10, 'Cantidad', 0, 0, 'C', 1);
        $fpdf->Cell(30, 10, 'Precio Total', 0, 0, 'C', 1);
        $fpdf->Ln(10);
        $productos = [];
        $cantidad = DB::table('detalleventa')->where('id_venta', $id_venta)->count();
        for ($i = 0; $i < $cantidad; $i++) {
            $detalle_vent = DB::table('productos')->where('id', $detalle_venta[$i]->id_producto)->get();
            foreach ($detalle_vent as $value) {
                array_push($productos, $value);
            }
        }
        $suma_total = 0;
        foreach ($detalle_venta as $venta) {
            $suma_total += $venta->precio * $venta->cantidad;
        }
        $fpdf->SetFont('Times', '', 8);
        foreach ($productos as $row) {
            $fpdf->Cell(20, 10, '');
            $fpdf->Cell(30, 10, $row->nombre_prod, 0, 0, 'C', 1);
            $ruta1 = "img_productos\\" . $row->usuario . "\\" . $row->nombre_img;
            $tipo = explode(".", $row->nombre_img);
            //$fpdf->Image("img_productos\\Admin\\082556-Mous.jpg", $fpdf->GetX(), $fpdf->GetY(), 10, 10, $tipo[1]);
            $fpdf->MultiCell(30, 10, $fpdf->Image("img_productos\\Admin\\082556-Mous.jpg", 70, $fpdf->GetY(), 10, $tipo[1]), 1, 'C');
            //$fpdf->Cell(30, 10, $row->nombre_prod, 0, 0, 'C', 1);
            //$fpdf->Cell(30, 10, $row->nombre_prod, 0, 0, 'C', 1);
            //$fpdf->Cell(30, 10, $row->nombre_prod, 0, 0, 'C', 1);
            $fpdf->Ln(10);
        }
        $fpdf->Output();
        exit;
    }
    public function orden_fecha($date)
    {
        $fecha = explode("-", $date);
        $dia = explode(" ", $fecha[2]);
        $orden = $dia[0] . "/" . $fecha[1] . "/" . $fecha[0];
        return $orden;
    }
}