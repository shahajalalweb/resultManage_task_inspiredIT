<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input and Show Result</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Left Side -->
        <div class="w-1/4 bg-blue-500 text-white p-4 flex flex-col items-center">
            <button id="inputResultBtn" class="w-full mb-4 py-2 bg-blue-700 hover:bg-blue-800 rounded">
                Input Result
            </button>
            <button id="showResultBtn" class="w-full py-2 bg-blue-700 hover:bg-blue-800 rounded">
                Show Result
            </button>
        </div>

        {{-- input filed  --}}
        <div class="w-3/4 bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Input Result</h1>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 mb-6 rounded-md">
                    {{ session('success') }}
                </div>
            @elseif (session('delete'))
                <div class="bg-green-100 text-red-700 p-4 mb-6 rounded-md">
                    {{ session('delete') }}
                </div>
            @elseif (session('error'))
                <div class="bg-green-100 text-red-400 p-4 mb-6 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('submitResult') }}" class="space-y-6">
                @csrf
                {{-- examination type  --}}
                <div class="mb-4">
                    <label for="examination" class="block text-sm font-semibold">Examination Type</label>
                    <select id="examination" name="examination" class="border w-full p-2" required>
                        <option value="Midterm">Midterm</option>
                        <option value="Final">Final</option>
                        <option value="Practical">Practical</option>
                    </select>
                </div>
                <!-- Roll Number Input -->
                <div>
                    <label for="roll" class="block text-sm font-medium text-gray-700 mb-1">Roll Number</label>
                    <input type="text" id="roll" name="roll" value="{{ old('roll') }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="Enter roll number" />
                    @error('roll')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Class Dropdown -->
                <div>
                    <label for="class" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                    <select id="class" name="class"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="" disabled selected>Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class['class'] }}">{{ $class['class'] }}</option>
                        @endforeach
                    </select>
                </div>


                <!-- Subject Input Fields -->
                <div id="subjects-container" class="space-y-4">
                    <!-- Subject input fields will be appended dynamically here -->
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 shadow">
                        Submit
                    </button>
                </div>
            </form>

            <!-- Table to Show Submitted Results -->
            <div class="w-3/4 mt-8 bg-white p-8 rounded-lg shadow-xl border border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Submitted Results</h2>

                <!-- Table displaying the saved results -->
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse text-left">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                                <th class="px-6 py-4 text-lg font-medium">Examination</th>
                                <th class="px-6 py-4 text-lg font-medium">Roll Number</th>
                                <th class="px-6 py-4 text-lg font-medium">Class</th>
                                <th class="px-6 py-4 text-lg font-medium">Subjects & Marks</th>
                                <th class="px-6 py-4 text-lg font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr class="bg-gray-50 hover:bg-gray-100 transition duration-200">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 border-t border-gray-300">
                                        {{ $result->examination }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 border-t border-gray-300">
                                        {{ $result->roll }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 border-t border-gray-300">
                                        {{ $result->class }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 border-t border-gray-300">
                                        <ul class="space-y-2">
                                            @foreach ($result->subjects_marks as $subject => $mark)
                                                <li class="flex justify-between">
                                                    <span class="font-semibold">{{ $subject }}</span>
                                                    <span class="text-green-600 font-bold">{{ $mark }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 border-t border-gray-300">
                                        <form action="{{ route('result.delete', $result->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 focus:outline-none">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

    </div>
    <script>
        // Pass PHP class data to JavaScript
        const classData = @json($classes);

        // Listen for class selection change to display subjects dynamically
        document.getElementById('class').addEventListener('change', function() {
            const selectedClass = this.value;
            const subjectsContainer = document.getElementById('subjects-container');

            // Clear previous subject fields
            subjectsContainer.innerHTML = '';

            // Find the selected class's subjects
            const selectedClassData = classData.find(cls => cls.class === selectedClass);

            if (selectedClassData) {
                selectedClassData.subjects.forEach(subject => {
                    // Create input fields for each subject
                    const fieldWrapper = document.createElement('div');
                    fieldWrapper.className = "mb-4";

                    // Subject Name Label
                    const label = document.createElement('label');
                    label.textContent = subject;
                    label.className = "block text-sm font-medium text-gray-700";

                    // Input Field for Marks
                    const input = document.createElement('input');
                    input.type = "number";
                    input.name = `marks[${subject}]`; // Use subject name as part of the input's name
                    input.placeholder = `Enter marks for ${subject}`;
                    input.className =
                        "block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm";
                    input.min = 1; // Minimum value
                    input.max = 100; // Maximum value

                    // Append label and input field to the wrapper
                    fieldWrapper.appendChild(label);
                    fieldWrapper.appendChild(input);

                    // Append the wrapper to the subjects container
                    subjectsContainer.appendChild(fieldWrapper);
                });
            }
        });
    </script>
</body>

</html>
