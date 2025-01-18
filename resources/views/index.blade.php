<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Aiman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .masonry-grid {
            column-count: 1;
            column-gap: 1rem;
        }
        @media (min-width: 640px) {
            .masonry-grid {
                column-count: 2;
            }
        }
        @media (min-width: 1024px) {
            .masonry-grid {
                column-count: 4;
            }
        }
        .masonry-item {
            display: inline-block;
            width: 100%;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-[#D9EAFD]">
    <div class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-[#BCCCDC] border border-[#9AA6B2] text-[#4A5568] px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah Jadwal -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-bold mb-4 text-[#9AA6B2]">Tambah Jadwal Baru</h2>
            <form action="{{ route('schedules.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-[#9AA6B2]">Judul Kegiatan</label>
                        <input type="text" name="title" class="mt-1 block w-full rounded-md border-[#BCCCDC] shadow-sm focus:border-[#9AA6B2] focus:ring focus:ring-[#9AA6B2] focus:ring-opacity-50" required>
                    </div>
                    
                    <div>
                        <label class="block text-[#9AA6B2]">Hari</label>
                        <select name="day" class="mt-1 block w-full rounded-md border-[#BCCCDC] shadow-sm focus:border-[#9AA6B2] focus:ring focus:ring-[#9AA6B2] focus:ring-opacity-50" required>
                            <option value="">Pilih Hari</option>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[#9AA6B2]">Waktu Mulai</label>
                            <input type="time" name="start_time" class="mt-1 block w-full rounded-md border-[#BCCCDC] shadow-sm focus:border-[#9AA6B2] focus:ring focus:ring-[#9AA6B2] focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-[#9AA6B2]">Waktu Selesai</label>
                            <input type="time" name="end_time" class="mt-1 block w-full rounded-md border-[#BCCCDC] shadow-sm focus:border-[#9AA6B2] focus:ring focus:ring-[#9AA6B2] focus:ring-opacity-50" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[#9AA6B2]">Deskripsi</label>
                        <textarea name="description" class="mt-1 block w-full rounded-md border-[#BCCCDC] shadow-sm focus:border-[#9AA6B2] focus:ring focus:ring-[#9AA6B2] focus:ring-opacity-50" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" class="bg-[#9AA6B2] text-white px-4 py-2 rounded-md hover:bg-[#BCCCDC] transition duration-300">
                        Tambah Jadwal
                    </button>
                </div>
            </form>
        </div>

        <!-- Tampilan Jadwal -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4 text-[#9AA6B2]">Jadwal Saya</h2>
            <div class="masonry-grid">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                    <div class="masonry-item">
                        <div class="bg-[#D9EAFD] rounded-lg p-4 shadow-md">
                            <h3 class="font-bold mb-2 text-[#9AA6B2]">{{ $day }}</h3>
                            <div class="space-y-2">
                                @foreach($schedules->where('day', $day) as $schedule)
                                    <div class="bg-white p-3 rounded-lg shadow-sm">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div class="font-medium text-[#9AA6B2]">{{ $schedule->title }}</div>
                                                <div class="text-sm text-[#BCCCDC]">
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                </div>
                                                @if($schedule->description)
                                                    <div class="text-sm mt-1 text-[#9AA6B2]">{{ $schedule->description }}</div>
                                                @endif
                                            </div>
                                            <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[#9AA6B2] hover:text-[#BCCCDC] transition duration-300">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>