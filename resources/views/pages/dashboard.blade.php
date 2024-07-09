<x-dashboard-layout>

    @php

     // Array of months in Italian
        $months = [
            "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
            "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
        ];
    @endphp

    <x-slot name="title">Dashboard</x-slot>

        <div class='dashboard-div'>

            <div class="dashboard-resumeTab-div">
                <div class="dashboard-header mt-4">
                    <form method="GET" action="/dashboard/home">
                        @csrf
                        <h1 class="dashboard-title">Riepilogo del mese di</h1>
                        <select name="dashMonthSelect" id="dashMonthSelect">
                            <?php foreach ($months as $month): ?>
                            <option value="<?= $month ?>" <?= $month === $selectedMonth ? 'selected' : '' ?>><?= $month ?></option>
                        <?php endforeach; ?>
                        </select>
                    </form>
                    <a href="/dashboard/summary">
                        <button>Riepilogo anno</button>
                    </a>
                    
                </div>
            </div>

            <div class="dashboard-resumeTab-div">
                <div class="dashboard-tabs">
                    <div class="summary-tab">
                        <div class="incomings-tab">
                            <h1>Totale Entrate</h1>
                            <p>{{ number_format($userTotalIncomingsOnMount, 2, ',', '.') }} €</p>
                        </div>
                        <div class="expenses-tab">
                            <h1>Totale Uscite</h1>
                            <p>{{ number_format($userTotalExpensesOnMount, 2, ',', '.') }} €</p>
                        </div>
                        <div class="balance-tab">
                            <h1>Bilancio</h1>
                            <p class={{ ($userTotalIncomingsOnMount - $userTotalExpensesOnMount) < 0 ? 
                                'negative' : 'positive'}}>{{ number_format(($userTotalIncomingsOnMount - $userTotalExpensesOnMount), 2, ',','.') }} €</p>
                        </div>
                    </div>                    
                </div>
        
                <div class="dashboard-tabs">
                    <div class="dash-table">
                        <table>
                            <tr>
                                <th></th>
                                <th class="center">Necessità</th>
                                <th class="center">Desideri</th>
                                <th class="center">Risparmio</th>
                            </tr>
                            <tr>
                                <td class="bold">Disponibili</td>
                                <td class="center">{{ number_format($userTotalIncomingsOnMount * 0.5, 2, ',', '.') }} €</td>
                                <td class="center">{{ number_format($userTotalIncomingsOnMount * 0.3, 2, ',', '.') }} €</td>
                                <td class="center">{{ number_format($userTotalIncomingsOnMount * 0.2, 2, ',', '.') }} €</td>
                            </tr>
                            <tr>
                                <td class="bold">Spesi</td>
                                <td class="center">{{ number_format($usrTotExpByType['total_amount'][0], 2, ',', '.') }} €</td>
                                <td class="center">{{ number_format($usrTotExpByType['total_amount'][1], 2, ',', '.') }} €</td>
                                <td class="center">{{ number_format($usrTotExpByType['total_amount'][2], 2, ',', '.') }} €</td>
                            </tr>
                            <tr style="border-top: 1px solid;">
                                <td class="bold">Saldo</td>
                                <td class="center bold">{{ number_format($userTotalIncomingsOnMount * 0.5 - $usrTotExpByType['total_amount'][0], 2, ',', '.') }} €</td>
                                <td class="center bold">
                                    {{
                                        ($userTotalIncomingsOnMount * 0.5) - $usrTotExpByType['total_amount'][0] < 0 ? 
                                            number_format((($userTotalIncomingsOnMount * 0.3) - $usrTotExpByType['total_amount'][1] + 
                                                ($userTotalIncomingsOnMount * 0.5) - $usrTotExpByType['total_amount'][0]), 2, ',', '.')
                                            : 
                                            number_format((($userTotalIncomingsOnMount * 0.3) - $usrTotExpByType['total_amount'][1]), 2, ',', '.')
                                            
                                    }} €
                                </td>
                                
                                
                                <td class="center bold">
                                    {{
                                        ($userTotalIncomingsOnMount * 0.5) - $usrTotExpByType['total_amount'][0] + (($userTotalIncomingsOnMount * 0.3) - $usrTotExpByType['total_amount'][1]) < 0 ? 
                                            number_format((($userTotalIncomingsOnMount * 0.2) - $usrTotExpByType['total_amount'][2] + ($userTotalIncomingsOnMount * 0.3) - $usrTotExpByType['total_amount'][1] + ($userTotalIncomingsOnMount * 0.5) - $usrTotExpByType['total_amount'][0]), 2, ',', '.')
                                            : 
                                            number_format((($userTotalIncomingsOnMount * 0.2) - $usrTotExpByType['total_amount'][2]), 2, ',', '.')
                                          
                                    }} €
                                </td>
                             
                            </tr>
                        </table>
                    </div>
                    
                    
                </div>  
                
                <div class="dashboard-tabs">
                    <div class="todo-tab">
                        <h1 class="bold">Spese da fare</h1>
                        <div class="todo-subtab">
                            @foreach ($userToDo as $item)
                                <div class="todo-div">
                                    <div class="todo-details">
                                        <p class="todo-title">{{ $item['title'] }}</p>
                                        <p class="todo-amount">{{ number_format($item['amount'], 2, ',', '.') }} €</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox"
                                               data-id="{{ $item['id'] }}"
                                               class="todo-checkbox"
                                               @if ($item['isDone']) checked @endif>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
            </div>

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

        
            <div class="dashboard-resumeTab-div">
                <div class="dashboard-graphs">
                    <div style="font-weight: bold">Ripartizione spese per tipologia primaria</div>

                    <div>
                        <canvas id="chartPrimaryExpensesDistribution" style="width: 250px;"></canvas>
                    </div>

                    <script>
                        const ctxExpPrimary = document.getElementById('chartPrimaryExpensesDistribution');
                    
                        const labelsExpPrimary = {!! json_encode($usrExpPrimaryCategoryMounthPercLists['labels'])!!};
                        const dataExpPrimary = {!! json_encode($usrExpPrimaryCategoryMounthPercLists['total_amount'])!!};
                        
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
            
        
        
    @push('scripts')
        @vite('resources/js/dashboard/dashSelect.js')
    @endpush

</x-dashboard-layout>
