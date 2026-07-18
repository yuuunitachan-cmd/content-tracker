namespace App\Exports;

use App\Models\Postingan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostinganExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filter;
    
    public function __construct($filter = null)
    {
        $this->filter = $filter;
    }
    
    public function query()
    {
        $query = Postingan::with(['jenisKonten', 'sumberKonten']);
        
        if ($this->filter && is_numeric($this->filter)) {
            $query->where('jenis_konten_id', $this->filter);
        }
        
        return $query;
    }
    
    public function headings(): array
    {
        return ['Judul', 'Link', 'Jenis', 'Sumber', 'Hashtag', 'Tanggal'];
    }
    
    public function map($postingan): array
    {
        return [
            $postingan->judul,
            $postingan->link,
            $postingan->jenisKonten->nama,
            $postingan->sumberKonten->nama,
            $postingan->hashtag,
            $postingan->created_at->format('d-m-Y'),
        ];
    }
}