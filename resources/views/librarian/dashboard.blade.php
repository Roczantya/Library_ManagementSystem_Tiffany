<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Librarian Dashboard</h1>
        <nav>
            <a href="{{ route('librarian.manage') }}">Manage Resources</a> |
            <a href="{{ route('logout') }}">Logout</a>
        </nav>
    </header>

    <main>
        <section id="manage-resources">
            <h2>Manage Resources</h2>
            <form action="{{ route('librarian.addResource') }}" method="POST">
                @csrf
                <select name="type" required>
                    <option value="book">Book</option>
                    <option value="journal">Journal</option>
                    <option value="cd">CD</option>
                    <option value="newspaper">Newspaper</option>
                    <option value="thesis">Thesis</option>
                </select>
                <input type="text" name="title" placeholder="Title" required>
                <button type="submit">Add</button>
            </form>

            <h3>Current Resources</h3>
            <ul>
                @foreach ($resources as $resource)
                    <li>
                        {{ ucfirst($resource->type) }}: {{ $resource->title }}
                        <form action="{{ route('librarian.deleteResource', $resource->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </section>

        <section id="student-requests">
            <h2>Student Requests</h2>
            <ul>
                @foreach ($studentRequests as $request)
                    <li>
                        Request: {{ $request->description }}
                        <form action="{{ route('librarian.approveRequest', $request->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Approve</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </section>
    </main>
</body>
</html>
