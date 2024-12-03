<x-admin_layout>
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="inn-title">
                        <h4>Add MOU Partner</h4>
                        <p>Here you can edit your website basic details URL, Phone, Email, Address, User and
                            password and more</p>
                    </div>
                    <div class="tab-inn">
                        <form action="{{ route('admin.partner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="name" value="{{ old('name') }}" class="validate"
                                        required>
                                    <label class="">Name</label>
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" class="validate" value="{{ old('web_address') }}"
                                        name="web_address">
                                    <label class="">Website Address</label>
                                    @error('web_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea name="description" id="editor">{{ old('description') }}</textarea>
                                    <label class="">Description</label>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="file-field input-field col s12">
                                    <div class="btn admin-upload-btn">
                                        <span>File</span>
                                        <input type="file" name="image">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Slide Image">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="waves-effect waves-light btn-large waves-input-wrapper"
                                        style=""><input type="submit" class="waves-button-input"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
        CKEDITOR.replace('editor', {
            filebrowserUploadUrl: "{{ route('admin.partner.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
        });
    </script>
    </div>
</x-admin_layout>
