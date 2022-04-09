<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{ route('user.edit', ['user' => $user->id]) }}">Edit</a>
                <form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="POST">
                    @csrf

                    @method('DELETE')

                    <button type="submit" class="submitButton">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
