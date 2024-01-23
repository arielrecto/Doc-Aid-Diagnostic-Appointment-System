<x-app-layout>
    <div class="main-screen">
        <x-admin.sidebar-new />

        <div class="main-content">
            <x-admin.navbar-new />

            @if (Session::has('rejected'))
                <div class="panel-error">
                    <span>
                        CODE ERROR - Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, dolor?
                    </span>
                </div>
            @endif

            @if (Session::has('approved'))
                <div class="panel-success">
                    <span>
                        CODE SUCCESS - Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, voluptatum?
                    </span>
                </div>
            @endif

            @if (Session::has('message'))
                <div class="panel-success">
                    <span>{{ Session::get('message') }}</span>
                </div>
            @endif

            <div class="panel overflow-y-auto">
                <h1 class="page-title">Create New Payment Account</h1>
                <div class="h-auto flex flex-col gap-2 rounded p-4">
                    <form action="{{ route('admin.paymentAccount.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col gap-2">
                            <label for="" class="text-sm text-gray-500">Bank Name</label>
                            <input type="text" class="input input-accent w-full" placeholder="Bank Name"
                                name="name">
                            @if ($errors->has('name'))
                                <p class="text-xs text-error">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="" class="text-sm text-gray-500">Account Name</label>
                            <input type="text" class="input input-accent w-full" placeholder="Account Name"
                                name="account_name">
                            @if ($errors->has('account_name'))
                                <p class="text-xs text-error">{{ $errors->first('account_name') }}</p>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="" class="text-sm text-gray-500">Account Number</label>
                            <input type="text" class="input input-accent w-full" placeholder="Account Number"
                                name="account_number">
                            @if ($errors->has('account_number'))
                                <p class="text-xs text-error">{{ $errors->first('account_number') }}</p>
                            @endif
                        </div>

                        <div class="flex flex-col gap-2" x-data="imagePreview">
                            <template x-if="imgSrc !== null">
                                <div class="flex flex-col gap-2 w-full h-64 p-5">
                                    <h1 class="text-lg font-bold gap-2">PREVIEW</h1>
                                    <div class="w-full flex justify-center h-full">
                                        <img :src="imgSrc" alt="" srcset="" class="h-full w-auto object object-center">
                                    </div>
                                </div>

                            </template>
                            <label for="" class="text-sm text-gray-500">Image</label>
                            <input type="file" class="file-input file-input-accent w-full" @change="imageHandler($event)" placeholder="Account Number"
                                name="image">
                            {{-- @if ($errors->has('account_number'))
                                <p class="text-xs text-error">{{ $errors->first('account_number') }}</p>
                            @endif --}}
                        </div>

                        <div class="flex justify-end p-2">
                            <button class="btn-generic btn-sm uppercase">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')

    <script>
        const imagePreview = () => ({
            imgSrc : null,
            imageHandler(e){
                const {files} = e.target;
                const reader = new FileReader();

                reader.onload = function (){
                    this.imgSrc = reader.result
                }.bind(this)

                reader.readAsDataURL(files[0]);
            }
        });
    </script>
    @endpush
</x-app-layout>
