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
									<b>Reporte de ventas</b><br />
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
                                <b>Jose Agudo</b><br />
									Supervisor de ventas<br />
									jagudo15@gmail.com
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

		</div>

        <p class="describe-table">Cuota mensual y total de ventas</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Cuota mensual</td>
                    <td>Total de ventas</td>
                </tr>
        
                <tr class="details">
                    <td>{{ number_format($CompanyGoalMonth->goal, 2) }}</td>
        
                    <td>{{ number_format($invoicesTotalMonth->total_amount, 2) }}</td>
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

        <p class="describe-table">Notas de crédito del periodo</p>
        <div class="invoice-box">
            <table>
                <tr class="heading">
                    <td>Factura</td>
                    <td>Cliente</td>
                    <td>Fecha</td>
                    <td>Monto</td>
                </tr>

                @php
                    $totalAmount = 0;
                @endphp

                @foreach ($creditNotesMonth as $creditNote)
                    <tr class="item">
                        <td>{{ $creditNote->invoice_number }}</td>
                        <td>{{ $creditNote->name }}</td>
                        <td>{{ date('d/m/Y', strtotime($creditNote->date)) }}</td>
                        <td>{{ number_format($creditNote->total, 2) }}</td>
                    </tr>

                    @php
                        $totalAmount += abs($creditNote->total);
                    @endphp

                @endforeach

                <tr class="total">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($totalAmount * -1, 2) }}</td>
                </tr>
            </table>
    </main>
	</body>
</html>