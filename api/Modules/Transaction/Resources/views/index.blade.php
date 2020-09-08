<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Data</th>
        <th>Cliente</th>
        <th>Operação</th>
        <th>Valor</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s') }}</td>
            <td>{{ $transaction->user->name }}</td>
            <td>{{ $transaction->type->title }}</td>
            <td>{{ $transaction->value }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
