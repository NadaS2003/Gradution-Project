@extends('layouts.student')
@section('title', 'تفاصيل الفرصة')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mx-auto p-6">
        <h2 class="text-2xl font-bold text-center mb-6">تفاصيل الفرصة</h2>

        <div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto border border-gray-200 py-10 px-10">
            <div class="flex flex-col md:flex-row items-start">

                <div class="flex-1 mr-5">
                    <h3 class="text-xl font-semibold text-gray-800 mb-5">{{ $internship->title }}</h3>
                    <p class="mt-2 text-black"><strong>الوصف:</strong> {{ $internship->description }}</p>
                    <p class="mt-2 text-black"><strong>اسم الشركة:</strong> {{ $internship->company->company_name }}</p>
                    <p class="mt-2 text-black"><strong>مدة التدريب:</strong> {{ $internship->duration }}</p>
                    <p class="mt-2 text-black"><strong>تاريخ بداية التدريب:</strong> {{ $internship->start_date }}</p>
                    <p class="mt-2 text-black"><strong>تاريخ نهاية التدريب:</strong> {{ $internship->end_date }}</p>
                    <p class="mt-2 text-black"><strong>البريد الإلكتروني:</strong> {{ $internship->company->user->email }}</p>
                    <p class="mt-2 text-black"><strong>الموقع الإلكتروني:</strong>
                        <a href="{{ $internship->company->website }}" target="_blank" class="text-blue-500 hover:underline">{{ $internship->company->website }}</a>
                    </p>
                    <p class="mt-2 text-black"><strong>رقم الهاتف:</strong> {{ $internship->company->phone_number }}</p>
                    <p class="mt-2 text-black"><strong>العنوان:</strong> {{ $internship->company->location }}</p>
                </div>

                <div class="ml-5 ">
                    <img src="{{ asset('storage/internships/' . $internship->image) }}" alt="Training Image" class="w-80 h-50 object-cover rounded-lg mr-5 shadow mt-10">

                    <div class="mr-60 mt-10">
                            <button class="bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-blue-700 transition"
                                    id="submitApplication"
                                    data-internship="{{ $internship->id }}"
                                    data-company="{{ $internship->company_id }}">
                                تقديم الطلب
                            </button>
                    </div>



                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#submitApplication').on('click', function() {
                // عرض التحذير باستخدام SweetAlert2
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "بمجرد الضغط على زر تقديم الطلب، سيُعتبر طلبك رسميًا سواء قمت بتعبئة النموذج أم لا.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، قدم الطلب',
                    cancelButtonText: 'لا، تراجع',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('applications.store') }}",
                            method: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                internship_id: $(this).data('internship'),
                                company_id: $(this).data('company')
                            },
                            success: function(data) {
                                if (data.success) {

                                    Swal.fire({
                                        title: 'تم تقديم طلبك بنجاح!',
                                        icon: 'success',
                                        confirmButtonText: 'موافق'
                                    });
                                    window.open(data.form_url, '_blank');
                                } else {

                                    Swal.fire({
                                        title: 'حدث خطأ!',
                                        text: data.message,
                                        icon: 'error',
                                        confirmButtonText: 'موافق'
                                    });
                                }
                            },
                            error: function(error) {

                                Swal.fire({
                                    title: 'خطأ!',
                                    text: 'حدث خطأ أثناء تقديم الطلب، يرجى المحاولة مرة أخرى.',
                                    icon: 'error',
                                    confirmButtonText: 'موافق'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection
