<?php

namespace Platform\JobStatusMaster;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobStatus extends Model
{
    public    $dates    = ['started_at', 'finished_at', 'created_at', 'updated_at'];
    protected $guarded  = [];

    protected $table    = 'etm_jobs_status';

    /* Accessor */
    public function getInputAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getOutputAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getProgressPercentageAttribute()
    {
        return $this->progress_max != 0 ? round(100 * $this->progress_now / $this->progress_max) : 0;
    }
    
    public function getIsEndedAttribute()
    {
        return in_array($this->status, ['failed', 'finished']);
    }

    public function getIsFinishedAttribute()
    {
        return in_array($this->status, ['finished']);
    }

    public function getIsFailedAttribute()
    {
        return in_array($this->status, ['failed']);
    }
    
    public function getIsExecutingAttribute()
    {
        return in_array($this->status, ['executing']);
    }

    /* Mutator */
    public function setInputAttribute($value)
    {
        $this->attributes['input'] = json_encode($value);
    }

    public function setOutputAttribute($value)
    {
        $this->attributes['output'] = json_encode($value);
    }
}
