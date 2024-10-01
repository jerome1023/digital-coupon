export type TPageDetails = {
    pageTitle: string;
    formTitle?: string;
    path: string;
};

export type TOptions = {
    code: string;
    name: string;
}[];

export type TTableColumn = {
    field: string | any;
    header: string;
};

export type TTableAction = {
    label: string;
    icon: string;
    severity: string;
    event?: Function
};

export type TTable = {
    columns: TTableColumn[];
    contents: Object[];
    actions?: TTableAction[];
};

export type TPageProps = {
    [key: string]: any;
};
