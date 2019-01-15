class Queue
{
    constructor() {
        this.items = [];
        this.hasSuccess = false;
        this.hasError = false;
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
        return this.count() == 0 && this.hasSuccess && this.hasError == false;
    }
}

export let queue = new Queue();