<x-dashboard-layout>

    @php

    @endphp

    <x-slot name="title">Riassunto annuale</x-slot>

    <div class='dashboard-div'>

        <div class="dashboard-resumeTab-div">
            <div class="dashboard-header mt-4">
                <form method="GET" action="/dashboard/summary">
                    @csrf
                    <h1 class="dashboard-title">Riepilogo </h1>
                    <select name="summaryYearSelect" id="summaryYearSelect">
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" {{ $year === $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </form>              
            </div>
        </div>

        <div class="dashboard-resumeTab-div">
            <div class="dashboard-graphs">
                <div style="font-weight: bold">Ripartizione spese annuale per tipologia primaria</div>

                <div>
                    <canvas id="chartPrimaryExpensesDistribution" style="width: 250px;"></canvas>
                </div>

                <script>
                    const ctxExpPrimary = document.getElementById('chartPrimaryExpensesDistribution');
                
                    const labelsExpPrimary = {!! json_encode($usrExpPrimaryCategoryAnnuallyPercLists['labels'])!!};
                    const dataExpPrimary = {!! json_encode($usrExpPrimaryCategoryAnnuallyPercLists['total_amount'])!!};
                    
                    new Chart(ctxExpPrimary, {
                        type: 'pie',
                        data: {
                            labels: labelsExpPrimary,
                            datasets: [{
                                label: '',
                                data: dataExpPrimary,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += context.parsed.toFixed(2) + '%';
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>

            <div class="dashboard-graphs">
                <div style="font-weight: bold">Ripartizione spese annuale per tipologia secondaria</div>

                <div>
                    <canvas id="chartSecondaryExpensesDistribution" style="width: 250px;"></canvas>
                </div>

                <script>
                    const ctxExpSecondary = document.getElementById('chartSecondaryExpensesDistribution');
                
                    const labelsExpSecondary = {!! json_encode($usrExpSecondaryCategoryAnnuallyPercLists['labels'])!!};
                    const dataExpSecondary = {!! json_encode($usrExpSecondaryCategoryAnnuallyPercLists['total_amount'])!!};
                    
                    new Chart(ctxExpSecondary, {
                        type: 'pie',
                        data: {
                            labels: labelsExpSecondary,
                            datasets: [{
                                label: '',
                                data: dataExpSecondary,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += context.parsed.toFixed(2) + '%';
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
        
        <div class="dashboard-resumeTab-div">
            <div class="dashboard-graphs">
                <div style="font-weight: bold">Andamento Spese, Guadagni e Risparmi nell'anno</div>

                <div class="lineChart-div">
                    <canvas id="lineChartExpenses" style="width: 100%;"></canvas>
                </div>

                <script>
                    const ctxLineChartSummary = document.getElementById('lineChartExpensesSummary').getContext('2d');;
                
                    const labelsLineChartSummary = {!! json_encode($usrExpMounthCumulativeSummary['day'])!!};
                    const dataLinechartSummary = {!! json_encode($usrExpMounthCumulativeSummary['cumulative_sum'])!!};
                    
                    new Chart(ctxLineChartSummary, {
                        type: 'line',
                        data: {
                            labels: labelsLineChartSummary,
                            datasets: [{
                                label: 'Spese',
                                data: dataLinechartSummary,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
        {{-- 
        <div class="dashboard-resumeTab-div">
            <div class="dashboard-tabs">
                <div class="dashboard-tablediv">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Entrata/Uscita</th>
                                <th>Categoria</th>
                                <th>Sottocategoria</th>
                                <th>Titolo</th>
                                <th>Descrizione</th>
                                <th>Importo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incomingExpenseUnion as $item)
                            <tr>
                            
                                <td>{{ \Carbon\Carbon::parse($item->union_date)->format('d-m-Y') }}</td>
                                <td class={{ ($item->identifier === 'Uscita') ? "tableDataNegativeStyle" : "tableDataPositiveStyle" }}>
                                    {{$item->identifier}}
                                </td>
                                <td>{{$item->category}}</td>
                                <td>{{$item->subcategory}}</td>
                                <td>{{$item->title}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{number_format($item->amount, 2, ',', '.')}} €</td>                       
                        
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>

    
        

            <div class="dashboard-graphs">
                <div style="font-weight: bold">Ripartizione spese per tipologia secondaria</div>

                <div>
                    <canvas id="chartSecondaryExpensesDistribution" style="width: 250px;"></canvas>
                </div>

                <script>
                    const ctxExpSecondary = document.getElementById('chartSecondaryExpensesDistribution');
                
                    const labelsExpSeondary = {!! json_encode($usrExpSecondaryCategoryMounthPercLists['labels'])!!};
                    const dataExpSecondary = {!! json_encode($usrExpSecondaryCategoryMounthPercLists['total_amount'])!!};
                    
                    new Chart(ctxExpSecondary, {
                        type: 'pie',
                        data: {
                            labels: labelsExpSeondary,
                            datasets: [{
                                label: '',
                                data: dataExpSecondary,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += context.parsed.toFixed(2) + '%';
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>

            <div class="dashboard-graphs">
                <div style="font-weight: bold">Andamento delle spese nel mese</div>

                <div class="lineChart-div">
                    <canvas id="lineChartExpenses" style="width: 100%;"></canvas>
                </div>

                <script>
                    const ctxLineChart = document.getElementById('lineChartExpenses').getContext('2d');;
                
                    const labelsLineChart = {!! json_encode($usrExpMounthCumulative['day'])!!};
                    const dataLinechart = {!! json_encode($usrExpMounthCumulative['cumulative_sum'])!!};
                    
                    new Chart(ctxLineChart, {
                        type: 'line',
                        data: {
                            labels: labelsLineChart,
                            datasets: [{
                                label: 'Spese',
                                data: dataLinechart,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>

        </div>

        <div class="dashboard-resumeTab-div">
            <div class="dashboard-tabs">
                <div class="dashboard-tablediv">
                    <table class="dashboard-table2">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th>Totale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usrTotExpBySubType['subtype'] as $index => $subtype)
                            <tr>
                                <td>{{ $subtype }}</td>
                                <td>{{ number_format($usrTotExpBySubType['total_amount'][$index], 2, ",", ".") }} €</td>                         
                            </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>

            <div class="dashboard-tabs">
                <div class="dashboard-tablediv">
                    <table class="dashboard-table2">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Credito/Debito</th>
                                <th>Descrizione</th>
                                <th>Totale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userCreditDebitOnMonth as $index)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($index->date)->format('d-m-Y') }}</td>
                                <td class={{ ($index->type === 'Debito') ? "tableDataNegativeStyle" : "tableDataPositiveStyle" }}>{{ $index->type }}</td>    
                                <td>{{ $index->description }}</td> 
                                <td>{{ number_format($index->amount, 2, ",",".") }} €</td>                    
                            </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>

            
        </div>

        <div class="margin"></div>
        
        

    </div>        
            
        
    --}}
    @push('scripts')
        @vite('resources/js/dashboard/summarySelect.js')
    @endpush

</x-dashboard-layout>
