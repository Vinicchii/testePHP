@extends('layouts.app')

@section('title', 'Bem-vindo')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-bar-chart-line-fill ps-2 me-2"></i>Visão Geral</h2>

    <div class="row">

        {{-- Coluna da esquerda com cards verticais --}}

        <div class="col-md-3 d-flex flex-column gap-3">


            <div class="card shadow p-2 border-0">
                <div class="card-body">
                    <h6 class="text-muted">Status dos Pedidos</h6>
                    <p class="mb-1 fw-semibold text-secondary">Em Aberto: <strong>{{ $pedidosEmAberto }}</strong></p>
                    <p class="mb-1 fw-semibold text-success">Pagos: <strong>{{ $pedidosPagos }}</strong></p>
                    <p class="mb-0 fw-semibold text-danger">Cancelados: <strong>{{ $pedidosCancelados }}</strong></p>
                </div>
            </div>

            <div class="card shadow p-2 border-0">
                <div class="card-body">
                    <h6><a class="text-muted text-decoration-none" href="{{ url('/pedidos') }}"><i class="bi bi-bag-fill me-2"></i>Pedidos</a></h6>
                    <h3 class="fw-bold">{{ $pedidosEmAberto }}</h3>
                </div>
            </div>

            <div class="card shadow p-2 border-0">
                <div class="card-body">
                    <h6><a class="text-muted text-decoration-none" href="{{ url('/clientes') }}"><i class="bi bi-person-fill me-2"></i>Clientes</a></h6>
                    <h3 class="fw-bold">{{ $totalClientes }}</h3>
                    <p class="mb-0 text-success">{{ $clientesComPedido }} com pedidos</p>
                </div>
            </div>

            <div class="card shadow p-2 border-0">
                <div class="card-body">
                    <h6><a class="text-muted text-decoration-none" href="{{ url('/produtos') }}"><i class="bi bi-box-seam-fill me-2"></i>Produtos</a></h6>
                    <h3 class="fw-bold">{{ $totalProdutos }}</h3>
                </div>
            </div>
        </div>

        {{-- Coluna da direita com círculo de faturamento e itens com clientes --}}

        <div class="col-md-6 d-flex flex-column align-items-center justify-content-start">

            {{-- Carrossel de Indicadores --}}

            <div id="indicadoresCarousel" class="carousel slide mb-4" data-bs-touch="false" data-bs-interval="false">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#indicadoresCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Faturamento Potencial"></button>
                    <button type="button" data-bs-target="#indicadoresCarousel" data-bs-slide-to="1" aria-label="Faturamento Realizado"></button>
                    <button type="button" data-bs-target="#indicadoresCarousel" data-bs-slide-to="2" aria-label="Pedidos Cancelados"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="rounded-circle bg-dark text-white d-flex flex-column justify-content-center align-items-center shadow" style="width: 250px; height: 250px;">
                            <h6 class="text-uppercase">Faturamento Potencial</h6>
                            <h2 class="fw-bold">R$ {{ number_format($faturamentoPotencial, 2, ',', '.') }}</h2>
                            <small>Pedidos em abertos e pagos</small>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="rounded-circle bg-success text-white d-flex flex-column justify-content-center align-items-center shadow" style="width: 250px; height: 250px;">
                            <h6 class="text-uppercase">Faturamento Realizado</h6>
                            <h2 class="fw-bold">R$ {{ number_format($faturamentoPago, 2, ',', '.') }}</h2>
                            <small>Pedidos pagos</small>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="rounded-circle bg-danger text-white d-flex flex-column justify-content-center align-items-center shadow" style="width: 250px; height: 250px;">
                            <h6 class="text-uppercase">Pedidos Cancelados</h6>
                            <h2 class="fw-bold">R$ {{ number_format($faturamentoCancelado, 2, ',', '.') }}</h2>
                            <small>Valor total cancelado</small>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#indicadoresCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#indicadoresCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>

            {{-- Itens com clientes em formato vertical --}}
            <div class="w-100 text-center">
                <h5 class="mb-3"><i class="bi bi-fire fs-3"></i>Top Hits</h5>
                @forelse ($produtosComClientes as $produto)
                    <div class="card border-0 shadow  mb-3 mx-auto" style="max-width: 250px;">
                        <div class="card-body">
                            <h6 class="fw-bold">{{ $produto['nome'] }}</h6>
                            <p class="mb-0 text-muted">Quantidade em pedidos: {{ $produto['quantidade'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Nenhum item em pedidos ainda.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
