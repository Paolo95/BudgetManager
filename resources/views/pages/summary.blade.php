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

                <div class="lineChartSummary-div">
                    <canvas id="lineChartExpensesSummary" style="width: 100%;"></canvas>
                </div>

                <script>
                    const ctxLineChartSummary = document.getElementById('lineChartExpensesSummary').getContext('2d');;
                
                    const labelsLineChartSummaryExp = {!! json_encode($usrExpMonthSummary['month'])!!};
                    const dataLinechartSummaryExp = {!! json_encode($usrExpMonthSummary['amount'])!!};

                    const labelsLineChartSummaryInc = {!! json_encode($usrIncMonthSummary['month'])!!};
                    const dataLinechartSummaryInc = {!! json_encode($usrIncMonthSummary['amount'])!!};

                    const labelsLineChartSummarySav = {!! json_encode($usrSavMonthSummary['month'])!!};
                    const dataLinechartSummarySav = {!! json_encode($usrSavMonthSummary['amount'])!!};
                    
                    new Chart(ctxLineChartSummary, {
                        type: 'line',
                        data: {
                            labels: labelsLineChartSummaryExp,
                            datasets: [{
                                label: 'Spese',
                                data: dataLinechartSummaryExp,
                                borderColor: 'rgba(211, 33, 33, 0.8)',
                                backgroundColor: 'rgba(211, 33, 33, 0.8)',
                                fill: false,
                                borderWidth: 1
                            },
                            {
                                label: 'Entrate',
                                data: dataLinechartSummaryInc,
                                borderColor: 'rgba(63, 211, 33, 0.8)',
                                backgroundColor: 'rgba(63, 211, 33, 0.8)',
                                fill: false,
                                borderWidth: 1
                            },
                            {
                                label: 'Risparmio',
                                data: dataLinechartSummarySav,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 1)',
                                fill: false,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                datalabels: {
                                    display: true,  
                                    color: 'black', 
                                    align: 'top',  
                                    formatter: (value, context) => {
                                        return value.toFixed(2); 
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                </script>
            </div>
        </div>

        <div class="dashboard-resumeTab-div">
            <div class="dashboard-graphs">
                <div style="font-weight: bold">Debiti e Crediti nell'anno</div>
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
                                @foreach ($userCreditDebitOnYear as $index)
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
        </div>

        <div class="dashboard-resumeTab-div">
            <div class="dashboard-graphs">
                <div style="font-weight: bold">Rapporto Uscite/Entrate</div>
                <div class="dashboard-tabs">
                    <div class="dashboard-tablediv" id="expIncRatioTable">
                        <table class="dashboard-table2">
                            <thead>
                                <tr>
                                    <th>Mese</th>
                                    <th>Entrate</th>
                                    <th>Uscite</th>
                                    <th>Rapporto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([0,1,2,3,4,5,6,7,8,9,10,11] as $index)
                                    <tr>
                                        <td>{{ $usrExpMonthSummary['month'][$index] }}</td>
                                        <td>{{ number_format($usrIncMonthSummary['amount'][$index], 2, ',','.') }} €</td>    
                                        <td>{{ number_format($usrExpMonthSummary['amount'][$index], 2, ',','.') }} €</td> 
                                        <td class={{ ($usrIncMonthSummary['amount'][$index] === 0 ? 1 : $usrExpMonthSummary['amount'][$index]/$usrIncMonthSummary['amount'][$index]) > 35 ? "tableDataNegativeStyle" : "tableDataPositiveStyle" }}>
                                            {{ $usrIncMonthSummary['amount'][$index] === 0 ? 
                                                number_format(0, 2, ',','.') : number_format($usrExpMonthSummary['amount'][$index]/$usrIncMonthSummary['amount'][$index] *100, 2, ',','.') }} %</td>                    
                                    </tr>                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="dashboard-resumeTab-div">
            <div class="dashboard-graphs">
                <div style="font-weight: bold">Andamento rapporto Uscite/Entrate</div>

                <div class="lineChartSummary-div" id="expIncRatioLine">
                    <canvas id="lineChartExpensesSummaryRatio" style="width: 100%;"></canvas>
                </div>

                <script>
                    const ctxLineChartSummaryRatio = document.getElementById('lineChartExpensesSummaryRatio').getContext('2d');
                
                    const labelsLineChartSummaryRatio = {!! json_encode($usrRatioMonthSummary['month'])!!};
                    const dataLinechartSummaryRatio = {!! json_encode($usrRatioMonthSummary['amount'])!!};
                    
                    new Chart(ctxLineChartSummaryRatio, {
                        type: 'line',
                        data: {
                            labels: labelsLineChartSummaryRatio,
                            datasets: [{
                                label: 'Uscite/Entrate',
                                data: dataLinechartSummaryRatio,
                                borderColor: 'rgba(211, 33, 33, 0.8)',
                                backgroundColor: 'rgba(211, 33, 33, 0.8)',
                                fill: false,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                datalabels: {
                                    display: true,  
                                    color: 'black', 
                                    align: 'top',  
                                    formatter: (value, context) => {
                                        return value.toFixed(2); 
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                </script>
            </div>
        </div>
        
    @push('scripts')
        @vite('resources/js/dashboard/summarySelect.js')
    @endpush

</x-dashboard-layout>
