@extends('layouts.app')

@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <h3>Posts Denunciados</h3>
            <p>Total de Denuncias: {{ $totalPosts }}</p>
            <a href="{{ route('admin.posts') }}" class="btn btn-primary">Gestionar</a>
        </div>
        <div class="col-sm-4">
            <h3>Usuarios Denunciados</h3>
            <p>Total de Denuncias: {{ $totalUsers }}</p>
            <a href="{{ route('admin.acounts') }}" class="btn btn-primary">Gestionar</a>
        </div>
        <div class="col-sm-4">
            <h3>Tags Denunciados</h3>
            <p>Total de Denuncias: {{ $totalTags }}</p>
            <a href="{{ route('admin.tags') }}" class="btn btn-primary">Gestionar</a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Estadísticas de Vistas</h3>
            <canvas id="viewsChart"></canvas>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">            
            <form action="{{ route('admin.filtro') }}" method="get">
                <div class="mb-3">
                    <div style="display: flex; align-items: center; padding: 0.5rem;">
                        <h6 for="filter" class="form-label" style="margin: 0;">Filtrar por:</h6>
                        <select name="filter" id="filter" class="form-select" style="height: auto; width: 120px; margin: 0 1rem;">
                            <option value="all"{{ request()->get('filter') == 'all' ? ' selected' : '' }}>Todo</option>
                            <option value="posts"{{ request()->get('filter') == 'posts' ? ' selected' : '' }}>Posts</option>
                            <option value="users"{{ request()->get('filter') == 'users' ? ' selected' : '' }}>Cuentas</option>
                            <option value="tags"{{ request()->get('filter') == 'tags' ? ' selected' : '' }}>Tags</option>
                            <option value="online_stores"{{ request()->get('filter') == 'online_stores' ? ' selected' : '' }}>Online Stores</option>
                            <option value="searches"{{ request()->get('filter') == 'searches' ? ' selected' : '' }}>Búsquedas</option>
                        </select>
                        <input type="text" name="search_term" id="search_term" placeholder="Término de búsqueda" class="form-control" style="width: 300px; margin-right: 1rem; height: auto;" value="{{ request()->get('search_term') }}">
                        <input type="date" name="start_date" id="start_date" placeholder="Fecha inicial" class="form-control" style="width: 150px; margin-right: 1rem;" value="{{ request()->get('start_date') }}">
                        <input type="date" name="end_date" id="end_date" placeholder="Fecha final" class="form-control" style="width: 150px; margin-right: 1rem;" value="{{ request()->get('end_date') }}">
                        <input type="time" name="start_time" id="start_time" placeholder="Hora inicio" class="form-control" style="width: 120px; margin-right: 1rem;" value="{{ request()->get('start_time') }}">
                        <input type="time" name="end_time" id="end_time" placeholder="Hora final" class="form-control" style="width: 120px; margin-right: 1rem;" value="{{ request()->get('end_time') }}">
                        <select name="date_range" id="date_range" class="form-select" style="height: auto; width: 120px; margin-right: 1rem;">
                            <option value="day"{{ request()->get('date_range') == 'day' ? ' selected' : '' }}>Día</option>
                            <option value="hour"{{ request()->get('date_range') == 'hour' ? ' selected' : '' }}>Hora</option>
                            <option value="week"{{ request()->get('date_range') == 'week' ? ' selected' : '' }}>Semana</option>
                            <option value="month"{{ request()->get('date_range') == 'month' ? ' selected' : '' }}>Mes</option>
                            <option value="year"{{ request()->get('date_range') == 'year' ? ' selected' : '' }}>Año</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="padding: .375rem .75rem; font-size: .875rem;">Aplicar filtro</button>
                    </div>
                </div>
            </form>                  
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Resultados del Filtro</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Elemento</th>
                        <th scope="col">Numero de elemento</th>
                        <th scope="col">Número de Vistas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($filteredResults as $result)
                    <tr>
                        <td>
                            
                            {{ $result->id_elemento==1? "Post":($result->id_elemento==2?"Tag":($result->id_elemento==3?"plataforma":"Cuenta")) }}</td>
                        <td>{{ $result->elemento }}</td>
                        <td>{{ $result->total_vistas }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $filteredResults->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var postViews = {!! json_encode($postViews) !!};
var userViews = {!! json_encode($userViews) !!};
var tagViews = {!! json_encode($tagViews) !!};
var onlineStoreViews = {!! json_encode($onlineStoreViews) !!};
var searchViews = {!! json_encode($searchViews) !!};

var postViewsTotal = collect(postViews).sum('numero_vista');
var userViewsTotal = collect(userViews).sum('numero_vista');
var tagViewsTotal = collect(tagViews).sum('numero_vista');
var onlineStoreViewsTotal = collect(onlineStoreViews).sum('numero_vista');
var searchViewsTotal = collect(searchViews).sum('numero_vista');
    var ctx = document.getElementById('viewsChart').getContext('2d');
    var viewsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Posts', 'Tags', 'Online Store', 'Usuarios', 'Búsquedas'],
            datasets: [
                {
                    label: 'Vistas',
                    data: [postViewsTotal, userViewsTotal, tagViewsTotal, onlineStoreViewsTotal, searchViewsTotal],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Estadísticas de Vistas por Elemento'
                },
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection
