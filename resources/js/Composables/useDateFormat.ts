import dayjs from 'dayjs';

export const convertDateFormat = (params: any) => {
    return dayjs(params, 'YYYY-MM-DD').format('YYYY-MM-DD');
}