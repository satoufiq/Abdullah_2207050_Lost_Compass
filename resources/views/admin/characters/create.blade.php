@extends('admin.layout')

@section('title', 'Add New Character')

@section('content')
<div class="card">
    <a href="{{ route('admin.characters.index') }}" style="margin-bottom: 20px; display: inline-block;">← Back to Characters</a>

    @if ($errors->any())
        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.characters.store') }}" method="POST">
        @csrf

        <div style="display: flex; gap: 20px;">
            <div style="flex: 1;">
                <div class="form-group">
                    <label>ID / Slug (Optional, leave blank to auto-generate from name)</label>
                    <input type="text" name="id" class="form-control" value="{{ old('id') }}">
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <input type="text" name="role" class="form-control" value="{{ old('role') }}" required>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control" required>
                        <option value="captains">Captains</option>
                        <option value="allies">Allies</option>
                        <option value="villains">Villains</option>
                        <option value="legends">Legends</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ship Name</label>
                    <input type="text" name="ship_name" class="form-control" value="{{ old('ship_name') }}">
                </div>
            </div>

            <div style="flex: 1;">
                <div class="form-group">
                    <label>Short Line (Used on card)</label>
                    <input type="text" name="short_line" class="form-control" value="{{ old('short_line') }}" required>
                </div>

                <div class="form-group">
                    <label>Quote</label>
                    <input type="text" name="quote" class="form-control" value="{{ old('quote') }}">
                </div>

                <div class="form-group">
                    <label>Weapon</label>
                    <input type="text" name="weapon" class="form-control" value="{{ old('weapon') }}">
                </div>

                <div class="form-group">
                    <label>First Appearance</label>
                    <input type="text" name="first_appearance" class="form-control" value="{{ old('first_appearance') }}">
                </div>
                
                <div class="form-group">
                    <label>Tags (Comma separated, e.g. allies, legends)</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags') }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Image Path (e.g. assets/images/characters/name.jpg)</label>
            <input type="text" name="image" class="form-control" value="{{ old('image') }}">
        </div>

        <div class="form-group">
            <label>Full Biography</label>
            <textarea name="biography" class="form-control" rows="5" required>{{ old('biography') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="font-size: 1.1rem; padding: 10px 20px;">Save Character</button>
    </form>
</div>
@endsection
