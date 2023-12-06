// order.service.ts

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class OrderService {
  private apiUrl = 'http://localhost:8000/orders';

  constructor(private http: HttpClient) {}

  getOrders(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}`).pipe(
      catchError(this.handleError)
    );
  }

  cancelOrder(id: number): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}/cancel`, {}).pipe(
      catchError(this.handleError)
    );
  }

  searchOrders(query: string, searchBy: string): Observable<any[]> {
    let queryField = '';
    switch (searchBy) {
      case 'status':
        queryField = 'status';
        break;    
      default:
        queryField = 'customer';
        break;
    }
    return this.http.get<any[]>(`${this.apiUrl}/search?${queryField}=${query}`).pipe(
      catchError(this.handleError)
    );
  }

  uploadOrders(file: File): Observable<any> {
    const formData: FormData = new FormData();
    formData.append('file', file, file.name);

    return this.http.post<any>(`${this.apiUrl}/upload-orders`, formData).pipe(
      catchError(this.handleError)
    );
  }

  private handleError(error: any) {
    console.error('API request error:', error);
    return throwError('Something went wrong. Please try again later.');
  }
}
