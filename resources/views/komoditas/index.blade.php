@extends('layouts.app')

@section('title', 'Data Komoditas')
@section('page-title', 'Data Komoditas')
@section('page-subtitle', 'Kelola data komoditas perkebunan')

@section('page-actions')
    <a href="#"
       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Tambah Komoditas
    </a>
@endsection

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        {{-- Search & Filter Bar --}}
        <div class="p-5 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="relative w-full sm:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </span>
                    <input type="text" placeholder="Cari komoditas..."
                           class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition"/>
                </div>
                <p class="text-sm text-gray-500">Menampilkan <span class="font-semibold text-gray-700">4</span> komoditas</p>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="px-5 py-3.5 text-left font-semibold text-gray-600 w-12">No</th>
                        <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Nama Komoditas</th>
                        <th class="px-5 py-3.5 text-center font-semibold text-gray-600">Satuan</th>
                        <th class="px-5 py-3.5 text-right font-semibold text-gray-600">Harga Jual</th>
                        <th class="px-5 py-3.5 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Row 1 --}}
                    <tr class="hover:bg-gray-50/60 transition">
                        <td class="px-5 py-4 text-gray-500">1</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.082-.147c.217-.39.07-.882-.332-1.081a.742.742 0 0 0-.546-.035 2.25 2.25 0 0 1-2.015-.37l-.06-.047A3.036 3.036 0 0 1 3 8.16v-.285C3 6.04 4.796 4.5 6.963 4.5h.654c.348 0 .694.042 1.032.124a4.59 4.59 0 0 0 2.16.058l.263-.066a1.503 1.503 0 0 1 1.525.39l.03.03c.276.276.708.276 1.1.106.655-.284 1.426-.144 1.914.344l.079.08a1.004 1.004 0 0 0 1.353.088l.09-.065c.382-.274.89-.185 1.16.196l.256.362a1.5 1.5 0 0 0 1.09.591l.286.03c.46.048.808.444.808.908v.063c0 .498-.2.976-.555 1.328l-.356.356Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Kelapa Butiran</p>
                                    <p class="text-xs text-gray-400">Kelapa utuh siap jual</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">butir</span>
                        </td>
                        <td class="px-5 py-4 text-right font-semibold text-gray-800">Rp 2.000</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                    </svg>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 2 --}}
                    <tr class="hover:bg-gray-50/60 transition">
                        <td class="px-5 py-4 text-gray-500">2</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.082-.147c.217-.39.07-.882-.332-1.081a.742.742 0 0 0-.546-.035 2.25 2.25 0 0 1-2.015-.37l-.06-.047A3.036 3.036 0 0 1 3 8.16v-.285C3 6.04 4.796 4.5 6.963 4.5h.654c.348 0 .694.042 1.032.124a4.59 4.59 0 0 0 2.16.058l.263-.066a1.503 1.503 0 0 1 1.525.39l.03.03c.276.276.708.276 1.1.106.655-.284 1.426-.144 1.914.344l.079.08a1.004 1.004 0 0 0 1.353.088l.09-.065c.382-.274.89-.185 1.16.196l.256.362a1.5 1.5 0 0 0 1.09.591l.286.03c.46.048.808.444.808.908v.063c0 .498-.2.976-.555 1.328l-.356.356Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Kopra</p>
                                    <p class="text-xs text-gray-400">Daging kelapa kering</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">kg</span>
                        </td>
                        <td class="px-5 py-4 text-right font-semibold text-gray-800">Rp 8.500</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                    </svg>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 3 --}}
                    <tr class="hover:bg-gray-50/60 transition">
                        <td class="px-5 py-4 text-gray-500">3</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.082-.147c.217-.39.07-.882-.332-1.081a.742.742 0 0 0-.546-.035 2.25 2.25 0 0 1-2.015-.37l-.06-.047A3.036 3.036 0 0 1 3 8.16v-.285C3 6.04 4.796 4.5 6.963 4.5h.654c.348 0 .694.042 1.032.124a4.59 4.59 0 0 0 2.16.058l.263-.066a1.503 1.503 0 0 1 1.525.39l.03.03c.276.276.708.276 1.1.106.655-.284 1.426-.144 1.914.344l.079.08a1.004 1.004 0 0 0 1.353.088l.09-.065c.382-.274.89-.185 1.16.196l.256.362a1.5 1.5 0 0 0 1.09.591l.286.03c.46.048.808.444.808.908v.063c0 .498-.2.976-.555 1.328l-.356.356Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Kelapa Muda</p>
                                    <p class="text-xs text-gray-400">Kelapa muda untuk minuman</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">butir</span>
                        </td>
                        <td class="px-5 py-4 text-right font-semibold text-gray-800">Rp 5.000</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                    </svg>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 4 --}}
                    <tr class="hover:bg-gray-50/60 transition">
                        <td class="px-5 py-4 text-gray-500">4</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.082-.147c.217-.39.07-.882-.332-1.081a.742.742 0 0 0-.546-.035 2.25 2.25 0 0 1-2.015-.37l-.06-.047A3.036 3.036 0 0 1 3 8.16v-.285C3 6.04 4.796 4.5 6.963 4.5h.654c.348 0 .694.042 1.032.124a4.59 4.59 0 0 0 2.16.058l.263-.066a1.503 1.503 0 0 1 1.525.39l.03.03c.276.276.708.276 1.1.106.655-.284 1.426-.144 1.914.344l.079.08a1.004 1.004 0 0 0 1.353.088l.09-.065c.382-.274.89-.185 1.16.196l.256.362a1.5 1.5 0 0 0 1.09.591l.286.03c.46.048.808.444.808.908v.063c0 .498-.2.976-.555 1.328l-.356.356Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Sabut Kelapa</p>
                                    <p class="text-xs text-gray-400">Serat sabut kelapa</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">kg</span>
                        </td>
                        <td class="px-5 py-4 text-right font-semibold text-gray-800">Rp 500</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
                                    </svg>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="px-5 py-4 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm text-gray-500">
                <p>Menampilkan 1-4 dari 4 data</p>
                <div class="flex items-center gap-1">
                    <button class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed" disabled>&laquo; Sebelumnya</button>
                    <button class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white font-medium">1</button>
                    <button class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed" disabled>Selanjutnya &raquo;</button>
                </div>
            </div>
        </div>
    </div>
@endsection
