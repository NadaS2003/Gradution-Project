@extends('layouts.company')

@section('content')
    <div class="mt-6">
        <div class="flex flex-col items-center px-3 py-2">
            <h2 class="text-2xl font-bold text-center mb-6">طلبات التدريب</h2>
        </div>
    </div>
    <div class="mt-5 mr-5 ml-8 mb-6">
        @if($applications->isEmpty())

            <div class="text-center text-gray-500">
                لا توجد طلبات تدريبية حاليا
            </div>
        @else
            <table class="w-full table table-bordered rounded">
                <thead class="thead-light">
                <tr>
                    <th class="px-4 py-2 border w-1/3 text-right">اسم الطالب</th>
                    <th class="px-4 py-2 border w-1/6 text-right">الفرصة التدريبية</th>
                    <th class="px-4 py-2 border w-1/6 text-right">حالة الطلب</th>
                    <th class="px-4 py-2 border w-1/6 text-right">الإجراءات</th>
                    <th class="px-4 py-2 border w-1/6 text-right">ملاحظات الإدارة</th>

                </tr>
                </thead>
                <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td class="px-4 py-2 border">{{ $application->student->full_name }}</td>
                        <td class="px-4 py-2 border">{{ $application->internship->title }}</td>

                        <td class="px-4 py-2 border status-column text-right
                            {{ $application->status == 'مقبول' ? 'text-green-500' :
                            ($application->status == 'مرفوض' ? 'text-red-500' :
                            ($application->status == 'قيد المراجعة' ? 'text-yellow-500' : '')) }}">
                            {{ $application->status }}
                        </td>


                        <td class="px-4 py-2 border text-right">
                            <div class="flex items-center gap-2">
                                <div class="inline-flex gap-2 action-buttons {{ in_array($application->status, ['مقبول', 'مرفوض']) ? 'hidden' : '' }}">
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 accept-btn"
                                            data-id="{{ $application->id }}">
                                        قبول
                                    </button>

                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 reject-btn"
                                            data-id="{{ $application->id }}">
                                        رفض
                                    </button>
                                </div>

                                <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 details-btn"
                                        data-name="{{ $application->student->full_name }}"
                                        data-id="{{ $application->student->university_id }}"
                                        data-email="{{ $application->student->user->email }}"
                                        data-phone="{{ $application->student->phone_number }}"
                                        data-major="{{ $application->student->major }}"
                                        data-year="{{ $application->student->academic_year }}"
                                        data-gpa="{{ $application->student->gpa }}"
                                        data-cv="{{ $application->student->cv_file ? asset('storage/' . $application->student->cv_file) : '' }}">
                                    تفاصيل
                                </button>
                            </div>
                        </td>

                        <td class="px-4 py-2 border text-right text-black-500">
                            @if($application->status == 'مقبول')
                                @if($application->admin_approval == 0)
                                    <span>
                                        بانتظار موافقة الإدارة
                                    </span>
                                @elseif($application->admin_approval == 1)
                                    <span>
                                        مقبول من الإدارة
                                    </span>
                                @elseif($application->admin_approval == -1)
                                    <span>
                                        مرفوض من الإدارة
                                    </span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <div class="mt-4 flex justify-end w-full">
            {{ $applications->links('vendor.pagination.simple-tailwind') }}
        </div>
        </div>

    <div id="studentModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-5 rounded-lg shadow-lg w-96 relative">
            <div class="border border-black border-opacity-20 rounded px-5 py-5">
                <button onclick="closeModal()" class="absolute top-7 left-8 text-gray-600 hover:text-red-600 text-xl font-bold">
                    &times;
                </button>

                <p class="mb-2"><strong>الاسم الكامل:</strong> <span id="studentName"></span></p>
                <p class="mb-2"><strong>الرقم الجامعي:</strong> <span id="studentId"></span></p>
                <p class="mb-2"><strong>البريد الإلكتروني:</strong> <span id="studentEmail"></span></p>
                <p class="mb-2"><strong>رقم الهاتف:</strong> <span id="studentPhone"></span></p>
                <p class="mb-2"><strong>التخصص:</strong> <span id="studentMajor"></span></p>
                <p class="mb-2"><strong>السنة الدراسية:</strong> <span id="studentYear"></span></p>
                <p class="mb-2"><strong>المعدل التراكمي:</strong> <span id="studentGpa"></span></p>

                <div class="mt-4 flex justify-start">
                    <a id="cvLink" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center inline-block" target="_blank">
                        ملف السيرة الذاتية
                    </a>
                </div>

            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".details-btn").forEach(button => {
                button.addEventListener("click", function () {
                    document.getElementById("studentName").textContent = this.getAttribute("data-name");
                    document.getElementById("studentId").textContent = this.getAttribute("data-id");
                    document.getElementById("studentEmail").textContent = this.getAttribute("data-email");
                    document.getElementById("studentPhone").textContent = this.getAttribute("data-phone");
                    document.getElementById("studentMajor").textContent = this.getAttribute("data-major");
                    document.getElementById("studentYear").textContent = this.getAttribute("data-year");
                    document.getElementById("studentGpa").textContent = this.getAttribute("data-gpa");

                    let cvUrl = this.getAttribute("data-cv");
                    let cvLink = document.getElementById("cvLink");

                    if (cvUrl && cvUrl.trim() !== "") {
                        cvLink.href = cvUrl;
                        cvLink.style.display = "block";
                    } else {
                        cvLink.style.display = "none";
                    }

                    document.getElementById("studentModal").classList.remove("hidden");
                });
            });

            window.closeModal = function () {
                document.getElementById("studentModal").classList.add("hidden");
            };
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".accept-btn, .reject-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let applicationId = this.getAttribute("data-id");
                    let status = this.classList.contains("accept-btn") ? "مقبول" : "مرفوض";
                    let row = this.closest("tr");
                    let statusColumn = row.querySelector(".status-column");
                    let actionButtons = row.querySelector(".action-buttons");

                    axios.post(`/applications/${applicationId}/update-status`, {
                        status: status
                    }, {
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => {
                            console.log(response.data);
                            if (response.data.success) {
                                statusColumn.textContent = response.data.new_status;
                                statusColumn.classList.remove("text-yellow-500", "text-green-500", "text-red-500");
                                statusColumn.classList.add(response.data.new_status === "مقبول" ? "text-green-500" : "text-red-500");
                                actionButtons.style.display = "none";
                            } else {
                                console.error("فشل تحديث الحالة: " + response.data.message);
                            }
                        })
                        .catch(error => {
                            console.error("حدث خطأ:", error);
                        });
                });
            });
        });


    </script>




@endsection
