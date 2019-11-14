@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="mr-auto">
                        My Expenses
                    </div> 
                    <div class="ml-auto">
                        Dashboard
                    </div>
                </div>


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!empty($expenses))
                        <div class="row">
                            <div class="col">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Expense Categories</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $expense)
                                            <tr>
                                                <td>{{ $expense['name'] }}</td>
                                                <td>{{ $expense['sum'] }}</td>
                                            </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col">
                                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
        
    </div>
</div>

@push('scripts')
    @if (!empty($expenses))
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script>
            window.onload = function() {
            
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "My Expenses"
                },
                data: [{
                    type: "pie",
                    startAngle: 240,
                    yValueFormatString: "##0.00\"%\"",
                    indexLabel: "{label} {y}",
                    dataPoints: [
                        <?php foreach ($expenses as $expense) : ?>
                            {y: <?php echo ((int)$expense['sum'] / $total) * 100 ?>, label: "<?php echo $expense['name'] ?>"},
                        <?php endforeach; ?>
                        // {y: 79.45, label: "Google"},
                        // {y: 7.31, label: "Bing"},
                        // {y: 7.06, label: "Baidu"},
                        // {y: 4.91, label: "Yahoo"},
                        // {y: 1.26, label: "Others"}
                    ]
                }]
            });
            chart.render();
            
            }
        </script>
    @endif
@endpush

@endsection
