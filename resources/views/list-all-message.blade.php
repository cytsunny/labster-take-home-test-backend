<html>
<head>
    <title>Message System Admin</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
    >
    <style>
        td {
            line-height: 32px;
        }
        form {
            margin-bottom: 0;
        }
        button[type=submit] {
            padding:0;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <section class="container">
        <h1>Message System Admin</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>User Email</th>
                <th>Message</th>
                <th>Result</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            @foreach($userMessages as $userMessage)
                <tr>
                    <td>{{ $userMessage->id }}</td>
                    <td>{{ $userMessage->user->email }}</td>
                    <td>{{ $userMessage->message }}</td>
                    <td>{{ $userMessage->result }}</td>
                    <td>{{ $userMessage->status }}</td>
                    <td>
                        @if ($userMessage->status !== 'done')
                            <form action="/user-message/{{ $userMessage->id }}" method="POST">
                                @csrf
                                <button type="submit">Process</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
</body>
</html>