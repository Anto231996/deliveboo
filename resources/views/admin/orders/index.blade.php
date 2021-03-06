@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="/dashboard">
                    &#8592; Ritorna alla Dashboard</a>
                <h1>Ordini ricevuti</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID Ordine</th>
                            <th scope="col">Piatti (Quantità)</th>
                            <th scope="col">Prezzo</th>
                            <th scope="col">Indirizzo</th>
                            <th scope="col">Data e Ora</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Cognome</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <th scope="row">{{ $order->id }}</th>
                                <td scope="row">
                                    @foreach ($order->dishes as $dish)
                                        {{ $dish->nome }} ({{ $dish->pivot->quantita }})<br>
                                    @endforeach
                                </td>
                                <td scope="row">{{ $order->prezzo }}</td>
                                <td scope="row">{{ $order->indirizzo }}</td>
                                <td scope="row">{{ $order->data_e_ora }}</td>
                                <td scope="row">{{ $order->nome }}</td>
                                <td scope="row">{{ $order->cognome }}</td>
                                <td scope="row">{{ $order->telefono }}</td>
                                <td scope="row">{{ $order->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td scope="row">Nessun ordine ricevuto.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
