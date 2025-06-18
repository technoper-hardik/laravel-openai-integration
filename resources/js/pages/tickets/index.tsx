import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { FormEvent } from 'react';

export interface Ticket {
    id: number;
    name: string;
    message: string;
    type: 'billing' | 'technical_support' | 'account_management' | 'feature_request' | null;
    type_status: 'pending' | 'completed' | 'failed';
    created_at: string; // ISO timestamp
    updated_at: string; // ISO timestamp
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tickets',
        href: '/tickets',
    },
];

export default function Index({ tickets }: { tickets: Ticket[] }) {
    const { data, setData, post, processing, reset } = useForm({
        name: '',
        message: '',
    });

    const submit = (e: FormEvent) => {
        e.preventDefault();
        post(route('tickets.store'), {
            onSuccess: () => reset(),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="space-y-6 p-6">
                <Card className="w-full">
                    <CardContent className="p-6">
                        <form onSubmit={submit} className="space-y-4">
                            <Input placeholder="Name" value={data.name} onChange={(e) => setData('name', e.target.value)} required />
                            <Textarea placeholder="Message" value={data.message} onChange={(e) => setData('message', e.target.value)} required />
                            <Button type="submit" disabled={processing}>
                                Submit Ticket
                            </Button>
                        </form>
                    </CardContent>
                </Card>

                <Card className="w-full">
                    <CardContent className="p-4">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Message</TableHead>
                                    <TableHead>Type</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Created At</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {tickets.map((ticket) => (
                                    <TableRow key={ticket.id}>
                                        <TableCell>{ticket.name}</TableCell>
                                        <TableCell className="max-w-[40vw] break-words whitespace-normal">{ticket.message}</TableCell>
                                        <TableCell>{ticket.type ?? '-'}</TableCell>
                                        <TableCell>{ticket.type_status}</TableCell>
                                        <TableCell>{new Date(ticket.created_at).toLocaleString()}</TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
