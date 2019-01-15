class Queue
{
    constructor() {
        this.items = [];
        this.hasSuccess = false;
    }

    add(id)
    {
        this.items.push(id);
    }

    remove(id)
    {
        this.items = this.items.filter((item) => {
            return id != item
        })
    }

    count()
    {
        return this.items.length;
    }
    
    allowsReload()
    {
        return this.count() == 0 && this.hasSuccess;
    }
}

export let queue = new Queue();