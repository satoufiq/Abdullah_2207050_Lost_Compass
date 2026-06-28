@extends('admin.layout')

@section('content')
<div style="margin-bottom: 2rem;">
    <h2>Add New Ship</h2>
    <p>Register a new legendary vessel.</p>
</div>

@if($errors->any())
    <div style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
        <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <form action="{{ route('admin.ships.store') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <!-- Column 1 -->
            <div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="name" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Ship Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="captain_id" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Captain</label>
                    <select name="captain_id" id="captain_id" style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                        <option value="">None</option>
                        @foreach($captains as $captain)
                            <option value="{{ $captain->id }}" {{ old('captain_id') == $captain->id ? 'selected' : '' }}>{{ $captain->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="type" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Type</label>
                    <input type="text" name="type" id="type" value="{{ old('type') }}" placeholder="e.g. Legendary Pirate Ship" style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="image" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Image Path</label>
                    <input type="text" name="image" id="image" value="{{ old('image') }}" placeholder="assets/images/ships/..." style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="tags" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Tags (comma separated)</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}" placeholder="all,legendary,cursed" style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                </div>
            </div>

            <!-- Column 2 -->
            <div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="speed" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Speed (0-10)</label>
                        <input type="number" name="speed" id="speed" value="{{ old('speed', 0) }}" min="0" max="10" required style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="attack_power" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Attack (0-10)</label>
                        <input type="number" name="attack_power" id="attack_power" value="{{ old('attack_power', 0) }}" min="0" max="10" required style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="defense" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Defense (0-10)</label>
                        <input type="number" name="defense" id="defense" value="{{ old('defense', 0) }}" min="0" max="10" required style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="curse_level" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Curse (0-10)</label>
                        <input type="number" name="curse_level" id="curse_level" value="{{ old('curse_level', 0) }}" min="0" max="10" required style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem; grid-column: span 2;">
                        <label for="legend_rank" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Legend Rank (0-10)</label>
                        <input type="number" name="legend_rank" id="legend_rank" value="{{ old('legend_rank', 0) }}" min="0" max="10" required style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="short_power" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Short Power / Subtitle</label>
                    <input type="text" name="short_power" id="short_power" value="{{ old('short_power') }}" style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                </div>
            </div>
        </div>

        <div style="margin-top: 1rem;">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="history" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">History / Lore</label>
                <textarea name="history" id="history" rows="4" style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">{{ old('history') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="weapons" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Weapons Details</label>
                    <input type="text" name="weapons" id="weapons" value="{{ old('weapons') }}" style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="curse" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Curse Description</label>
                    <input type="text" name="curse" id="curse" value="{{ old('curse') }}" style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="fate" style="display: block; margin-bottom: 0.5rem; color: #c9a44c;">Fate</label>
                    <input type="text" name="fate" id="fate" value="{{ old('fate') }}" style="width: 100%; padding: 0.8rem; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 4px;">
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1); display: flex; gap: 1rem;">
            <button type="submit" class="btn">Save Ship</button>
            <a href="{{ route('admin.ships.index') }}" class="btn" style="background: transparent; border: 1px solid rgba(255,255,255,0.2);">Cancel</a>
        </div>
    </form>
</div>
@endsection
