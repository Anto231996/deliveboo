@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <div class="col-12">
                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @elseif (session('delete-message'))
                                <div class="alert alert-danger">
                                    {{ session('delete-message') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <a href="/dishes/create" class="btn btn-primary">Aggiungi piatto</a>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrizione</th>
                        <th scope="col">Ingredienti</th>
                        <th scope="col">Prezzo</th>
                        <th scope="col">Visibilità</th>
                        <th scope="col">Modifica / Cancella</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dishes as $dish)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $dish->nome }}</td>
                            <td>{{ $dish->descrizione }}</td>
                            <td>{{ $dish->ingredienti }}</td>
                            <td>{{ $dish->prezzo }}</td>
                            <td>{{ $dish->visibilita ? '✓' : 'X' }}</td>
                            <td>
                                <a href="{{ route('dishes.edit', $dish) }}" class="btn btn-secondary">Modifica</a>

                                <form action="{{ route('dishes.destroy', $dish) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button id="elimina" type="submit" class="btn btn-danger">Elimina</button>
                                </form>

                                {{-- <a class="btn btn-danger">Elimina Bella</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('script')
    <script>
        const btn = document.querySelectorAll('#elimina');
        console.log(btn);

        for (let i = 0; i < btn.length; i++) {
            btn[i].addEventListener('click', function(event) {
                event.preventDefault();
                const form = event.target.form;

                swal({
                        title: "Sei sicuro?",
                        text: "Una volta eliminato non sarà più possibile recuperarlo.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            setTimeout(() => {
                                form.submit();
                            }, 800);
                            swal("Poof! Il tuo piatto è stato eliminato!", {
                                icon: "success",
                                buttons: false,
                            });
                        }
                    });


            })
        }
    </script>
@endsection
