<h1 class="mb-8 font-extrabold text-blue-dark text-5xl">Edit Theme</h1>

<form action="{{ route('themes.update', $theme) }}" method="post" role="form">
    @csrf
    @method('patch')

    <input type="hidden" name="name" value="New Name 2">
    <input type="hidden" name="location" value="{{ $theme->location }}">

    <button type="submit" class="button button-primary button-large">Update</button>
</form>