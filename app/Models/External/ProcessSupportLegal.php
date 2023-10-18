<?php


namespace App\Models\External;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeeCompany
 *
 * @package App\Application\Models
 */
class ProcessSupportLegal extends Eloquent
{
    /** @var string */
    protected $table = 'pregao_has_inciso';

    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $fillable
        = array(
            'cod_pregao',
            'cod_inciso',
        );

    /** @return Process */
    public function process(): Process
    {
        return $this->belongsTo(Process::class, 'cod_pregao')->getResults();
    }

    /** @return SupportLegal */
    public function supportLegal(): SupportLegal
    {
        return $this->belongsTo(SupportLegal::class, 'cod_inciso')->getResults();
    }
}
