<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Reporte de ventas</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

            main{
                max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            }

			.invoice-box {

				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td {
				border-top: 2px solid #eee;
				font-weight: bold;
                text-decoration: underline;
			}

             .describe-table {
                    font-size: 16px;
                    font-weight: bold;
                    text-align: left;
                    text-decoration: underline;
                    padding-bottom: 5px;
            }

            .describe-report {
                    font-size: 18.5px;
                    font-weight: bold;
                    text-align: center;
                    padding-bottom: 5px;
                    font-style: italic;
                    color: #555;
            }

            h6 {
                margin: 0;
                padding: 0;
                font-size: 24px;
            }

            .page-break {
                page-break-after: always;
            }

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}

  
			}

            footer {
                display: fixed;
                bottom: 0;
                width: 100%;
                text-align: center;
                color: #777;
                font-size: 12px;
                padding: 10px;
                border-top: 1px solid #eee;
                
            }

		</style>
	</head>

	<body>

        <main>
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="{{ $logo }}" alt="Company logo" style="width: 100%; max-width: 200px" />
								</td>

								<td>
									<b><h6>Reporte de ventas</h6></b><br />
									Fecha inicial: {{ date('d/m/Y', strtotime($start_date)) }}<br />
									Fecha final: {{ date('d/m/Y', strtotime($end_date)) }}<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									<b>{{ $companyName }} S.A.</b><br />
									Santiago de Veraguas<br />
                                    La Pita Vía a San Francisco
								</td>

								<td>
                                    <b>Enrique Puga</b><br />
									supventas@gathanasiadisr.com<br />
									<b>Jose Agudo</b><br />
                                    supventas2@gathanasiadisr.com
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

		</div>

        <p class="describe-report"><b>Ventas General</b></p>
        <p class="describe-table">Cuota mensual y total de ventas</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Cuota mensual</td>
                    <td>Total de ventas</td>
                    <td style="text-align: center">Porcentaje de cumplimiento</td>
                </tr>
        
                <tr class="details">
                    <td>{{ number_format($CompanyGoalMonth->goal, 2) }}</td>
        
                    <td>{{ number_format($invoicesTotalMonth->total_amount, 2) }}</td>
                    
                    {{-- Calcular porcentaje --}}
                    @php
                        $goal = $CompanyGoalMonth->goal;
                        $totalAmount = $invoicesTotalMonth->total_amount;
                        $goalPercentage = ($totalAmount / $goal) * 100;
                        $goalPercentageColor = ($goalPercentage >= 100) ? 'green' : (($goalPercentage >= 80) ? 'yellow' : 'red');
                    @endphp
                    <td style="color: {{ $goalPercentageColor }}; text-align: center">{{ number_format($goalPercentage > 100 ? 100 : $goalPercentage, 2) }}%</td>
                </tr>
            </table>
        </div>

        <p class="describe-table">Ventas agrupadas por vendedor y cuota mensual</p>
        <div class="invoice-box">
            <table>
				<tr class="heading">
					<td>Vendedor</td>
                    <td>Cuota mensual</td>
                    <td>Total de ventas</td>
                    <td>Porcentaje de cumplimiento</td>
                    <td>Comisión</td>
				</tr>
                @php
                    //acumulador de cuota mensual, total de ventas y comisión
                    $totalGoal = 0;
                    $totalAmount = 0;
                    $totalCommission = 0;
                @endphp

                @foreach ($invoicesGroupedOneSeller as $invoice)
                    <tr class="item">
                        <td>{{ $invoice->name }}</td>
                        <td>{{ number_format($invoice->goal, 2) }}</td>
                        <td>{{ number_format($invoice->total_amount, 2) }}</td>
                        <td style="color: {{ $invoice->goal_percentage_color  }}">{{ number_format($invoice->goal_percentage, 2) }}%</td>
                        <td>{{ number_format($invoice->commission, 2) }}</td>
                    </tr>
                    @php
                        $totalGoal += $invoice->goal;
                        $totalAmount += $invoice->total_amount;
                        $totalCommission += $invoice->commission;
                    @endphp

                @endforeach

                <tr class="total">
                    <td></td>
                    <td>{{ number_format($totalGoal, 2) }}</td>
                    <td>{{ number_format($totalAmount, 2) }}</td>
                    <td></td>
                    <td>{{ number_format($totalCommission, 2) }}</td>
                </tr>
            </table>
        </div>

        <p class="describe-table">Ventas agrupadas por clientes con mayor monto</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Cliente</td>
                    <td>Total de ventas</td>
                </tr>


                @foreach ($customersTop10 as $customer)
                    <tr class="item">
                        <td>{{ $customer->name }}</td>
                        <td>{{ number_format($customer->total_amount, 2) }}</td>
                    </tr>

                @endforeach

            </table>
        </div>

        <p class="describe-table">Ventas agrupadas por tipos de clientes con mayor monto</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Grupo de clientes</td>
                    <td>Total de ventas</td>
                </tr>



                @foreach ($customersGroupedTop10 as $customer)
                    <tr class="item">
                        <td>{{ $customer->group_name }}</td>
                        <td>{{ number_format($customer->total_amount, 2) }}</td>
                    </tr>
                    @php
                        $totalAmount += $customer->total_amount;
                    @endphp

                @endforeach
            </table>
        </div>

        <p class="describe-table">Ventas agrupadas por productos con mayor monto</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Producto</td>
                    <td>Total de ventas</td>
                </tr>

                @foreach ($productsTop10 as $product)
                    <tr class="item">
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->total_amount, 2) }}</td>
                    </tr>

                @endforeach
            </table>
        </div>

    </main>
    <div class="page-break"></div>

    <main>
        @if($invoicesTotalSpecial->total_amount > 0)
        <p class="describe-report"><b>Entregas especiales</b></p>
        <p class="describe-table">Resumen de entregas</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Total</td>
                </tr>
        
                <tr class="details">
                    <td>{{ number_format($invoicesTotalSpecial->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <p class="describe-table">Entregas agrupadas por vendedor</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Vendedor</td>
                    <td>Total de entregas</td>
                </tr>

                @php
                    //acumulador de total de ventas
                    $totalAmount = 0;
                @endphp
        
                @foreach ($invoicesGroupedOneSellerSpecial as $invoice)
                    <tr class="item">
                        <td>{{ $invoice->name }}</td>
                        <td>{{ number_format($invoice->total_amount, 2) }}</td>
                    </tr>
                    @php
                        $totalAmount += $invoice->total_amount;
                    @endphp
                @endforeach

                <tr class="total">
                    <td></td>
                    <td>{{ number_format($totalAmount, 2) }}</td>
                </tr>
            </table>
        </div>

        <p class="describe-table">Entregas agrupadas por clientes con mayor monto</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Cliente</td>
                    <td>Total de entregas</td>
                </tr>
        
                @foreach ($customersTop10Special as $customer)
                    <tr class="item">
                        <td>{{ $customer->name }}</td>
                        <td>{{ number_format($customer->total_amount, 2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <p class="describe-table">Entregas agrupadas por productos con mayor monto</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Producto</td>
                    <td>Total de entregas</td>
                </tr>
        
                @foreach ($productsTop10Special as $product)
                    <tr class="item">
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->total_amount, 2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        @endif

        <p class="describe-table">Total de ventas y entregas</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Ventas</td>
                    <td style="text-align: center">Entregas</td>
                    <td style="text-align: right">Total</td>
                </tr>
        
                <tr class="total">
                    <td>{{ number_format($invoicesTotalMonth->total_amount, 2) }}</td>
                    <td style="text-align: center">{{ number_format($invoicesTotalSpecial->total_amount, 2) }}</td>
                    <td style="text-align: right">{{ number_format($invoicesTotalMonth->total_amount + $invoicesTotalSpecial->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>


        {{-- Grafico de ventas por mes --}}
        @php

            $values = implode(',', $salesMonths);
        @endphp

        <br />
        
        <p class="describe-table"><b>Gráfico comparativo de ventas y entregas por mes</b></p>
        <img src="https://quickchart.io/chart?c={type:'bar',data:{labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],datasets:[{label:'Monto Total',data:[{{ $values }}]}],plugins:{datalabels:{anchor:'end',align:'end'}}}}" alt="Gráfico de ventas por mes" style="width: 100%; max-width: 800px" />

    </main>

    <footer>
        <p>MicroVendSoft | AB Cloud &copy; 2024</p>
	</body>
</html>