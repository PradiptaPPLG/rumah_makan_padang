@extends('layouts.admin')

@section('title', 'Log Sistem - Raso Mandeh')
@section('header_title', 'Log Sistem Administrator')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-neutral-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-neutral-100 bg-neutral-50 flex items-center justify-between">
            <h3 class="font-bold text-neutral-800">Riwayat Aktivitas Sistem</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-neutral-50/50 border-b border-neutral-200 text-[10px] uppercase tracking-widest text-neutral-500">
                        <th class="px-6 py-4 font-bold">Waktu</th>
                        <th class="px-6 py-4 font-bold">Pengguna</th>
                        <th class="px-6 py-4 font-bold">Aksi</th>
                        <th class="px-6 py-4 font-bold">Detail</th>
                        <th class="px-6 py-4 font-bold">IP Address</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($logs as $log)
                    <tr class="border-b border-neutral-100 hover:bg-neutral-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-neutral-600 text-xs">
                            {{ $log->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-[#7A1F2B]/10 text-[#7A1F2B] font-bold text-[10px] flex items-center justify-center">
                                    {{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="font-semibold text-neutral-800">{{ $log->user->name ?? 'Sistem' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide
                                {{ $log->action == 'Login' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-neutral-600 text-xs">
                            {{ $log->description }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-neutral-500 text-xs font-mono">
                            {{ $log->ip_address }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-neutral-400">
                            Belum ada log sistem.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-neutral-100 bg-white">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
